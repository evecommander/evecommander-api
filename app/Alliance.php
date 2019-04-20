<?php

namespace App;

use App\Abstracts\Organization;
use Illuminate\Support\Carbon;

/**
 * Class Alliance.
 *
 * @property string id
 * @property int api_id
 * @property string name
 * @property string default_membership_level
 * @property array settings
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property Coalition coalition
 * @property \Illuminate\Database\Eloquent\Collection corporations
 *
 */
class Alliance extends Organization
{
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Get relation between this alliance and the coalition it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function coalition()
    {
        return $this->memberships()->where('organization_type', Coalition::class)->with('organization');
    }

    /**
     * Get relation between this alliance and any corporations that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function corporations()
    {
        return $this->members()->where('member_type', Corporation::class)->with('member');
    }
}
