<?php

namespace services;

use services\items\UserService;
use components\api\twitch\TwitchApi;
use components\core\{ BaseService, BaseApiResponse };
use components\api\twitch\response\TwitchDataResponse;

/**
 * Class TwitchService
 *
 * @package services
 */
class TwitchService extends BaseService
{
    private TwitchApi $twitchApi;

    /**
     * @param TwitchApi $twitchApi
     */
    public function __construct(TwitchApi $twitchApi)
    {
        $this->twitchApi = $twitchApi;
    }

    /**
     * @param ?int $user_id
     *
     * @return TwitchDataResponse
     */
    public function getDataByUserID(?int $user_id = null): TwitchDataResponse
    {
        if (!$user_id) $user_id = (new UserService)->getInstance()->getCurrentUserId();

        $userData = $this->twitchApi->getUserData($user_id);

        //$twitchCountersResponse = $this->constructResponse( new TwitchDataResponse, $userData );
        /** @var TwitchDataResponse $twitchCountersResponse */
        $twitchCountersResponse = BaseApiResponse::constructItem(new TwitchDataResponse, [
            'followers' => $userData['counter']['followers'],
            'subscribers' => $userData['counter']['subscribers'],
            'streams' => $userData['streams']['count'],
            'views' => $userData['streams']['views'],
            'clips' => $userData['streams']['clips'],
        ]);

        return $twitchCountersResponse;
    }
}