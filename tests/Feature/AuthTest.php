<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A test using correct login credentials.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $userInfo = $this->generateUser();

        $this->doLogin($userInfo['user']->email, $userInfo['password'])
            ->assertOk()
            ->assertJson([
                'token_type' => 'bearer',
            ]);
    }

    /**
     * A test using incorrect login credentials.
     *
     * @return void
     */
    public function testLoginFailure()
    {
        $userInfo = $this->generateUser();

        $this->doLogin($userInfo['user']->email, $this->faker->password())
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    /**
     * A test of the route to get the current user.
     *
     * @return void
     */
    public function testMeRoute()
    {
        $userInfo = $this->getSampleUser();

        $this->post('/me', [], [
            'authorization' => "bearer {$userInfo['token']}",
        ])
            ->assertOk()
            ->assertJson($userInfo['user']->getVisible());
    }

    /**
     * A test of the route for refreshing a JWT.
     *
     * @return void
     */
    public function testRefreshRoute()
    {
        $userInfo = $this->getSampleUser();

        $this->post('/refresh', [], [
            'authorization' => "bearer {$userInfo['token']}",
        ])
            ->assertOk()
            ->assertJson([
                'token_type' => 'bearer',
            ]);
    }

    /**
     * A test of the route for logging out.
     *
     * @return void
     */
    public function testLogout()
    {
        $userInfo = $this->getSampleUser();

        $this->post('/logout', [], [
            'authorization' => "bearer {$userInfo['token']}",
        ])
            ->assertOk()
            ->assertJson([
                'message' => 'Successfully logged out',
            ]);
    }
}
