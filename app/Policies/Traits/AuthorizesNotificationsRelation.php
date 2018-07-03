<?php

namespace App\Policies\Traits;

use App\Abstracts\Organization;
use Illuminate\Http\Request;

trait AuthorizesNotificationsRelation
{
    /**
     * @param Organization $organization
     * @param Request      $request
     *
     * @return bool
     */
    public function readReadNotification(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'notifications', 'read', $request);
    }

    /**
     * @param Organization $organization
     * @param Request      $request
     *
     * @return bool
     */
    public function modifyReadNotifications(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'notifications', 'modify', $request);
    }

    /**
     * @param Organization $organization
     * @param Request      $request
     *
     * @return bool
     */
    public function readUnreadNotification(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'notifications', 'read', $request);
    }

    /**
     * @param Organization $organization
     * @param Request      $request
     *
     * @return bool
     */
    public function modifyUnreadNotifications(Organization $organization, Request $request)
    {
        return $this->authorizeRelation($organization, 'notifications', 'modify', $request);
    }
}
