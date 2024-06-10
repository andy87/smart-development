<?php

namespace components\api\twitch\response;

use components\core\BaseApiResponse;

class TwitchDataResponse extends BaseApiResponse
{
    public int $followers;

    public int $views;

    public int $streams;

    public int $clips;

    public int $subscribers;
}