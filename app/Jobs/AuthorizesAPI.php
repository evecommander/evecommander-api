<?php

namespace App\Jobs;

class AuthorizesAPI
{
    const EVE_AUTH_URL = 'https://login.eveonline.com/oauth/token';

    /**
     * Get the prepared header for Basic Authorization.
     *
     * @return string
     */
    protected function getBasicAuthHeader()
    {
        return 'Authorization: Basic '.base64_encode(env('EVE_CLIENT_ID').':'.env('EVE_SECRET'));
    }
}
