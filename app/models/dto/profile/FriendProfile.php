<?php

namespace models\dto\profile;

/**
 * Class FriendProfile
 *
 * @package models\dto\profile
 */
class FriendProfile
{
    public const TEMPLATE = 'profile/include/friend';


    public int $id;

    public string $nickname;

    public int $followers;

    /**
     * @return string
     */
    public function urlToProfile(): string
    {
        return '/profile/' . $this->id;
    }
}