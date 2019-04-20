<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $resourceType = 'users';

    public function testSearch()
    {
        $this->assertCannotSearch();
    }

    public function testSearchById()
    {
        $this->assertCannotSearch();
    }

    public function testCreate()
    {
        $this->assertCannotCreate();
    }

    public function testRead()
    {
        $userInfo = $this->getSampleUser();
        $expected = $this->api()->encoder()->serializeData($userInfo['user']);

        $this->doRead($userInfo['user']->getKey(), [], [
            'Authorization' => "Bearer {$userInfo['token']}",
        ])->assertRead($expected);
    }

    public function testReadUnauthorized()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $this->doRead($user->getKey())->assertStatus(401);
    }

    public function testUpdate()
    {
        $userInfo = $this->getSampleUser();
        /** @var User $user */
        $user = $userInfo['user'];
        $user->save();

        $data = [
            'type'       => 'users',
            'id'         => $user->getKey(),
            'attributes' => [
                'settings' => [
                    'test' => 'something',
                ],
            ],
        ];

        $response = $this->doUpdate($data, [], [
            'Authorization' => "Bearer {$userInfo['token']}",
        ]);

        $response->assertUpdated($data['attributes']['settings']);

        $this->assertEquals($user->settings, User::find($user->getKey())->settings);
    }

    public function testUpdateUnauthorized()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $data = [
            'type'       => 'users',
            'id'         => $user->getKey(),
            'attributes' => [
                'settings' => [
                    'test' => 'something',
                ],
            ],
        ];

        $this->doUpdate($data)->assertStatus(401);

        $this->assertDatabaseHas('users', [
            $user->getKeyName() => $user->getKey(),
            'email'             => $user->email,
        ]);
    }
}
