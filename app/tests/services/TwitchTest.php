<?php

namespace tests\services;

use components\api\twitch\TwitchApi;

/**
 * Class TwitchTest
 *
 * @package tests\services
 */
class TwitchTest
{
    /**
     * @var TwitchApi $twitchApi
     */
    private TwitchApi $twitchApi;

    /**
     * @return void
     */
    public function init(): void
    {
        $this->twitchApi = new TwitchApi();
    }

    /**
     * @return void
     */
    public function testGetUserData(): void
    {
        $response = $this->twitchApi->getUserData(1);

        $this->assertHasKeys($response, ['followers', 'views', 'streams', 'clips', 'subscribers']);
    }
}