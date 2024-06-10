<?php

namespace tests\services\models;

use models\dto\profile\UserProfile;
use models\sources\User;
use services\models\UserService;

/**
 * Class UserServiceTest
 *
 * @package tests\services
 */
class UserServiceTest
{
    /**
     * @var UserService $userService
     */
    private UserService $userService;

    /**
     * @return void
     */
    public function init(): void
    {
        $this->userService= new UserService();
    }

    /**
     * @return void
     */
    public function testGetUserById(): void
    {
        $userProfile = $this->userService->getUserProfile(1);

        $this->assertInstance($userProfile, UserProfile::class);

        $this->assertEquals($userProfile->id, 1);
    }

    /**
     * @return void
     */
    public function testGetCurrentUserId(): void
    {
        $currentUserId = $this->userService->getCurrentUserId();

        $this->assertEquals($currentUserId, 1);
    }

    /**
     * @return void
     */
    public function testFindItemByCriteria(): void
    {
        $user = $this->userService->findItemByCriteria(['id' => 1]);

        $this->assertInstance($user, User::class);

        $this->assertEquals($user->id, 1);
    }

    /**
     * @return void
     */
    public function testConstructUserProfile(): void
    {
        $user = new User();
        $user->id = 1;
        $user->nickname = 'one';
        $user->avatar = 'one.jpg';

        $userProfile = $this->userService->constructUserProfile($user);

        $this->assertInstance($userProfile, UserProfile::class);

        $this->assertEquals($userProfile->id, 1);
        $this->assertEquals($userProfile->nickname, 'one');
        $this->assertEquals($userProfile->avatar, $_ENV['path_upload_avatar'] . 'one.jpg');
    }

    /**
     * @return void
     */
    public function testConstructUserProfileCounters(): void
    {
        $user = new User();
        $user->id = 1;
        $user->nickname = 'one';
        $user->avatar = 'one.jpg';

        $userProfile = $this->userService->constructUserProfile($user);

        $this->assertInstance($userProfile, UserProfile::class);

        $this->assertEquals($userProfile->id, 1);
        $this->assertEquals($userProfile->nickname, 'one');
        $this->assertEquals($userProfile->avatar, $_ENV['path_upload_avatar'] . 'one.jpg');
        $this->assertEquals($userProfile->followers, 0);
        $this->assertEquals($userProfile->views, 0);
        $this->assertEquals($userProfile->subscribers, 0);
    }
}