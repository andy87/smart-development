<?php

namespace services;

use components\api\youtube\response\YoutubeDataResponse;
use components\api\youtube\YoutubeApi;
use components\core\BaseApiResponse;
use components\core\BaseService;
use services\models\UserService;

/**
 * Class YouTubeService
 *
 * @package services
 */
class YouTubeService extends BaseService
{
    private YoutubeApi $youtubeApi;

    /**
     * @param YoutubeApi $youtubeApi ;
     */
    public function __construct(YoutubeApi $youtubeApi)
    {
        $this->youtubeApi = $youtubeApi;
    }

    /**
     * @param ?int $user_id
     *
     * @return YoutubeDataResponse
     */
    public function getDataByUserID(?int $user_id = null): YoutubeDataResponse
    {
        if (!$user_id) $user_id = (new UserService)->getInstance()->getCurrentUserId();

        $userData = $this->youtubeApi->getUserData($user_id);

        //$twitchCountersResponse = $this->constructResponse( new TwitchDataResponse, $userData );
        /** @var YoutubeDataResponse $twitchCountersResponse */
        $twitchCountersResponse = BaseApiResponse::constructItem(new YoutubeDataResponse, [
            'followers' => $userData['counter']['followers'],
            'subscribers' => $userData['counter']['subscribers'],
            'streams' => $userData['streams']['count'],
            'views' => $userData['streams']['views'],
            'clips' => $userData['streams']['clips'],
        ]);

        return $twitchCountersResponse;
    }
}