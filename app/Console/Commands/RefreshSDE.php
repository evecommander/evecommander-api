<?php

namespace App\Console\Commands;

use App\Exceptions\BadResponseException;
use App\Exceptions\ChecksumMismatchException;
use App\Exceptions\NotFoundException;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

class RefreshSDE extends Command
{
    const SDE_BASE_URL = 'https://www.fuzzwork.co.uk/dump/';
    const SDE_SCHEMA_URI = 'postgres-schema-latest.dmp.bz2';
    const SDE_DATA_URI = 'postgres-latest.dmp.bz2';
    const SDE_LOCAL_FILE = 'eve-sde.dmp';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:sde {--f|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the static data database by pulling a fresh copy from '.self::SDE_BASE_URL;

    /**
     * @var Client
     */
    protected $client = null;

    /**
     * @var ProgressBar $progressBar
     */
    protected $progressBar = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri'               => self::SDE_BASE_URL,
            RequestOptions::PROGRESS => function ($downloadTotal, $downloadedBytes) {
                if ($downloadTotal <= 0) {
                    return;
                }

                if (!isset($this->progressBar)) {
                    $this->progressBar = $this->output->createProgressBar();
                    $this->progressBar->setFormat('debug');
                    $this->progressBar->setOverwrite(true);
                    $this->progressBar->start($downloadTotal);

                    return;
                }

                if ($downloadTotal > $downloadedBytes) {
                    $this->progressBar->setProgress($downloadedBytes);

                    return;
                }

                $this->progressBar->finish();
                $this->progressBar->clear();
                $this->progressBar = null;
            }
        ]);

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->getFile(self::SDE_SCHEMA_URI);

        if (!$this->verifyChecksum(self::SDE_SCHEMA_URI)) {
            throw new ChecksumMismatchException('MD5 hash mismatch for '.self::SDE_SCHEMA_URI);
        }

        $this->line("\nDecompressing Data File");
        $decompressed = bzdecompress(Storage::disk('local')->get(self::SDE_SCHEMA_URI));

        $this->line("Writing decompressed data to ".storage_path('app/'.self::SDE_LOCAL_FILE));
        Storage::disk('local')->put(self::SDE_LOCAL_FILE, $decompressed);
        unset($decompressed);

        $this->applyUpdates();
    }

    /**
     * @param $uri
     *
     * @throws \Exception
     */
    private function getFile($uri)
    {
        $cacheThreshold = Carbon::create()->subHours(3);
        $localDisk = Storage::disk('local');

        if (!$this->option('force') &&
            $localDisk->exists($uri) &&
            Carbon::createFromTimestamp($localDisk->lastModified($uri))->greaterThanOrEqualTo($cacheThreshold)) {
            $this->line("\nLocal file less than 3 hours old. Using cached version...");

            return;
        }

        $this->line("\nGetting file {$uri}");
        $response = $this->client->get($uri);

        if ($response->getStatusCode() > 299) {
            throw new BadResponseException("Error retrieving file {$uri}");
        }

        $this->line("\nWriting file to ".storage_path('app/'.$uri));

        if (!Storage::disk('local')->put($uri, $response->getBody())) {
            throw new \Exception("Error writing to file {$uri}");
        }
    }

    /**
     * @param string $uri
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function verifyChecksum(string $uri)
    {
        $expected = $this->getChecksum($uri);
        $checksum = md5_file(storage_path("app/{$uri}"));

        $this->line("\nVerifying checksum for {$uri}");
        $this->table(['Expected', 'Calculated'], [[$expected, $checksum]]);

        $matches = $expected === $checksum;

        if ($matches) {
            $this->line("YES! The checksums match!");
        } else {
            $this->error("OH NOES, the checksums don't match...");
        }

        return $matches;
    }

    /**
     * @param string $filename
     *
     * @return string
     *
     * @throws \Exception
     */
    private function getChecksum(string $filename)
    {
        $this->line("\nRetrieving MD5 hash for $filename");
        $this->getFile($filename.'.md5');
        $md5Lines = explode("\n", Storage::disk('local')->get("{$filename}.md5"));

        foreach ($md5Lines as $line) {
            $lineArray = explode(' ', $line);

            if (end($lineArray) === $filename) {
                return reset($lineArray);
            }
        }

        throw new NotFoundException('Error finding correct MD5 hash');
    }

    private function applyUpdates()
    {
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');
        $file = storage_path("app/".self::SDE_LOCAL_FILE);
        $output = [];
        $return = 0;
        $command = "PGPASSWORD=\"{$password}\" pg_restore --host={$host} --port={$port} --username={$username} --dbname={$database} --role=postgres --clean --if-exists --no-owner {$file}";

        $this->line("Running restore command\n$command");

        exec($command, $output, $return);

        foreach ($output as $index => $line) {
            $this->line("{$index}: {$line}");
        }

        if ($return === 0) {
            $this->line("Restore command finished successfully");
        } else {
            $this->error("Error running restore command");
        }
    }
}
