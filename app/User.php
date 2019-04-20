<?php

namespace App;

use App\Abstracts\Organization;
use App\Contracts\HasNotificationsContract;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use League\OAuth2\Server\Exception\OAuthServerException;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User.
 *
 * @property string id
 * @property string email
 * @property string password
 * @property array settings
 * @property bool is_admin
 * @property bool is_email_verified
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection notifications
 * @property \Illuminate\Database\Eloquent\Collection readNotifications
 * @property \Illuminate\Database\Eloquent\Collection unreadNotifications
 * @property \Illuminate\Database\Eloquent\Collection characters
 */
class User extends Authenticatable implements HasNotificationsContract
{
    use HasApiTokens, Notifiable, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'is_admin',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_admin' => 'boolean',
        'is_email_verified' => 'boolean',
    ];

    /**
     * @param $password
     * @return bool
     *
     * @throws OAuthServerException
     */
    public function validateForPassportPasswordGrant($password)
    {
        if (Hash::check($password, $this->getAuthPassword())) {
            // check that the user's email is verified
            if ($this->is_email_verified) {
                return true;
            } else {
                throw new OAuthServerException('User account is not active', 6, 'account_inactive', 401);
            }
        }

        return false;
    }

    /**
     * @param Model  $organization
     * @param string $target
     * @param string $action
     *
     * @return bool
     */
    public function hasCharacterWithPermission(Model $organization, string $target, string $action): bool
    {
        return $this->characters()->whereHas('roles', function (Builder $builder) use ($organization, $target, $action) {
            $builder->where('organization_id', '=', $organization->id)
                ->where('organization_type', '=', get_class($organization))
                ->whereHas('permissions', function (Builder $query) use ($target, $action) {
                    $query->where('slug', '=', Str::snake("{$target}_{$action}"));
                });
        })->exists();
    }

    /**
     * Get any characters that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}
