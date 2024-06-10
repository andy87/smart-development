<?php

namespace components\api\youtube\response;

use components\core\BaseApiResponse;

/**
 * Class YoutubeCountersResponse
 *
 * @package components\api\youtube\response
 */
class YoutubeDataResponse extends BaseApiResponse
{
    public int $followers;

    public int $views;

    public int $subscribers;
}