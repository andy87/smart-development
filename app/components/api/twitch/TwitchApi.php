<?php

namespace components\api\twitch;

/**
 * Class TwitchApi
 *
 * @package components\api\twitch
 */
class TwitchApi
{
    /**
     * @param int $user_id
     *
     * @return array
     */
    public function getUserData(int $user_id): array
    {
        //code request on documentation
        // fake code
        return [
            'followers' => rand( $user_id, ($user_id + 100 ) ),
            'views' => rand( $user_id, ($user_id + 100 ) ),
            'streams' => rand( $user_id, ($user_id + 100 ) ),
            'clips' => rand( $user_id, ($user_id + 100 ) ),
            'subscribers' => rand( $user_id, ($user_id + 100 ) ),
        ];
    }
}