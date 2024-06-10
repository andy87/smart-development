<?php

namespace resources\profile;

use components\core\resources\TemplateResources;
use models\dto\profile\FriendProfile;
use models\dto\profile\UserProfile;

/**
 * Class ProfileMeResources
 *
 * @package resources\profile
 */
class ProfileMeResources extends TemplateResources
{
    public const TEMPLATE = '@views/profile/me';

    /**
     * @var UserProfile $userProfile
     */
    public UserProfile $userProfile;

    /**
     * @var FriendProfile[]
     */
    public array $friendProfileList = [];
}