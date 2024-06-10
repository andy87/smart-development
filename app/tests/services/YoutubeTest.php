<?php

namespace tests\services;

use components\api\youtube\YoutubeApi;

/**
 * Class YoutubeTest
 *
 * @package tests\services
 */
class YoutubeTest
{
    /**
     * @var YoutubeApi $youtubeApi
     */
    private YoutubeApi $youtubeApi;

    /**
     * @return void
     */
    public function init(): void
    {
        $this->youtubeApi = new YoutubeApi();
    }

    /**
     * @return void
     */
    public function testGetUserData(): void
    {
        $response = $this->youtubeApi->getUserData(1);

        $this->assertHasKeys($response, ['followers', 'views', 'subscribers']);
    }
}