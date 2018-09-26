<?php

namespace Tests;

use App\User;
use Carbon\Carbon;
use CloudCreativity\LaravelJsonApi\Testing\MakesJsonApiRequests;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker, MakesJsonApiRequests, DatabaseTransactions;

    protected $api = 'v1';

    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var string $password
     */
    protected $password;

    public function setUp()
    {
        parent::setUp();
        Carbon::setTestNow();
    }

    /**
     * @return array
     */
    protected function getSampleUser()
    {
        $userInfo = $this->generateUser();
        $userInfo['token'] = $this->getAccessToken($userInfo['user'], $userInfo['password']);

        return $userInfo;
    }

    /**
     * @return array
     */
    protected function generateUser()
    {
        $password = $this->faker->password();

        return [
            'user'     => factory(User::class)->create(['password' => Hash::make($password)]),
            'password' => $password
        ];
    }

    /**
     * @param User $user
     * @param string $password
     * @return mixed
     */
    protected function getAccessToken(User $user, string $password)
    {
        return $this->doLogin($user->email, $password)->json('access_token');
    }

    /**
     * @param $email
     * @param $password
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function doLogin($email, $password)
    {
        return $this->json('POST','/login', [
            'email' => $email,
            'password' => $password,
        ]);
    }
}
