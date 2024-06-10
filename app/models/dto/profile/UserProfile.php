<?php

namespace models\dto\profile;

/**
 * Class UserProfile
 *
 * @package models\dto\profile
 */
class UserProfile
{
    public int $id;

    public string $nickname;

    public string $avatar;

    public int $followers;

    public int $views;

    public int $subscribers;
}