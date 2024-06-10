<?php

namespace controllers\api;

use components\core\BaseController;
use resources\profile\ProfileMeResources;
use services\items\UserService;

/**
 * Class ProfileController
 *
 * @package controllers
 *
 */
class ProfileController extends BaseController
{
    /**
     * @return array
     */
    public function actionMe(): array
    {
        $R = new ProfileMeResources();

        $userService = UserService::getInstance();

        $R->userProfile = $userService->getUserProfile();
        $R->friendProfileList = $userService->getFriendProfileList($R->userProfile->id);

        return $R->release();
    }
}