<?php

namespace components\api\youtube;

/**
 * Class YoutubeApi
 *
 * @package components\api\youtube
 */
class YoutubeApi
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
            'subscribers' => rand( $user_id, ($user_id + 100 ) ),
        ];
    }
}