<?php

namespace models\sources;

use components\core\BaseModel;

/**
 * Class User
 *
 * @package models\sources
 */
class User extends BaseModel
{
    public const ATTR_ID = 'id';

    public const ATTR_NICK_NAME = 'nickname';
    public const ATTR_AVATAR = 'avatar';


    public int $id;

    public string $nickname;
    public string $avatar;

    public int $twitch_id;
    public int $youtube_id;


    /**
     * @return string
     */
    public function getAvatarSrc(): string
    {
        return $_ENV['path_upload_avatar'] . $this->avatar;
    }
}