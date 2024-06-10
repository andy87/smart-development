<?php

namespace tests\api;

use components\api\youtube\YoutubeApi;

/**
 * Class YoutubeApiTest
 *
 * @package tests\api
 */
class YoutubeApiTest
{
    /**
     * @var YoutubeApi $youtubeApiTest
     */
    private YoutubeApi $youtubeApiTest;

    /**
     * @return void
     */
    public function init(): void
    {
        $this->youtubeApiTest = new YoutubeApi();
    }

    /**
     * @return void
     */
    public function testGetUserData(): void
    {
        $response = $this->youtubeApiTest->getUserData(1);

        $this->assertHasKeys($response, ['followers', 'views', 'subscribers']);
    }
}