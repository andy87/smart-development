<?php

namespace models\sources;

/**
 * Class Friend
 *
 * @package models\sources
 */
class Friend
{
    public const ATTR_ID = 'id';

    public const ATTR_USER_ID = 'user_id';

    public const ATTR_FRIEND_ID = 'friend_id';


    public int $id;

    public int $user_id;

    public int $friend_id;
}