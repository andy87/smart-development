<?php

namespace services;

use components\api\youtube\response\YoutubeCountersResponse;
use components\api\youtube\YoutubeApi;
use components\core\BaseApiResponse;
use components\core\BaseService;
use services\items\UserService;

/**
 * Class YouTubeService
 *
 * @package services
 */
class YouTubeService extends BaseService
{
    private YoutubeApi $youtubeApi;

    /**
     * @param YoutubeApi $youtubeApi;
     */
    public function __construct(YoutubeApi $youtubeApi)
    {
        $this->youtubeApi = $youtubeApi;
    }

    /**
     * @param ?int $user_id
     *
     * @return YoutubeCountersResponse
     */
    public function getDataByUserID(?int $user_id = null): YoutubeCountersResponse
    {
        if (!$user_id) $user_id = (new UserService)->getInstance()->getCurrentUserId();

        $userData = $this->youtubeApi->getUserData($user_id);

        //$twitchCountersResponse = $this->constructResponse( new TwitchDataResponse, $userData );
        /** @var YoutubeCountersResponse $twitchCountersResponse */
        $twitchCountersResponse = BaseApiResponse::constructItem(new YoutubeCountersResponse, [
            'followers' => $userData['counter']['followers'],
            'subscribers' => $userData['counter']['subscribers'],
            'streams' => $userData['streams']['count'],
            'views' => $userData['streams']['views'],
            'clips' => $userData['streams']['clips'],
        ]);

        return $twitchCountersResponse;
    }
}