<?php

namespace controllers;

use components\core\BaseController;
use resources\profile\ProfileMeResources;
use services\models\UserService;

/**
 * Class ProfileController
 *
 * @package controllers
 *
 * @method string render( string $template, array $params = [])
 */
class ProfileController extends BaseController
{
    /**
     * @return string
     */
    public function actionMe(): string
    {
        $R = new ProfileMeResources();

        $userService = UserService::getInstance();

        $R->userProfile = $userService->getUserProfile();
        $R->friendProfileList = $userService->getFriendProfileList($R->userProfile->id);

        return $this->render($R::TEMPLATE, $R->release() );
    }
}