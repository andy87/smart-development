<?php

namespace services\models;

use models\sources\User;
use components\core\{BaseModel, BaseService};
use models\dto\{ Counters, counters\Counter };
use services\{ YouTubeService, TwitchService };
use repository\{ UserRepository, FriendRepository };
use models\dto\profile\{ UserProfile, FriendProfile };

/**
 * Class UserService
 *
 * @package services\items
 *
 * @method User|string getClassModel()
 * @method User getModel(array $attributes)
 */
class UserService extends BaseService
{
    protected BaseModel|string $classModel = User::class;

    protected UserRepository $userRepository;
    protected FriendRepository $friendRepository;


    /**
     * @param ?int $user_id
     *
     * @return ?UserProfile
     */
    public function getUserProfile(?int $user_id = null): ?UserProfile
    {
        if (!$user_id) $user_id = $this->getCurrentUserId();

        $user = $this->findItemByCriteria([User::ATTR_ID => $user_id]);

        return ($user) ? $this->constructUserProfile($user) : null;
    }

    /**
     * @return int
     */
    public function getCurrentUserId(): int
    {
        // код получения ID текущего пользователя
        return 1;
    }

    /**
     * @param array $criteria
     *
     * @return ?User
     */
    public function findItemByCriteria(array $criteria): ?User
    {
        return $this->userRepository->findItemByCriteria($criteria);
    }

    /**
     * @param User $user
     *
     * @return UserProfile
     */
    public function constructUserProfile(User $user): UserProfile
    {
        $userProfile = new UserProfile();

        $userProfile->id = $user->id;
        $userProfile->nickname = $user->nickname;
        $userProfile->avatar = $user->getAvatarSrc();

        $counters = $this->constructCounters($user);

        $userProfile->followers = $counters->totalCounter->followers;
        $userProfile->views = $counters->totalCounter->views;
        $userProfile->subscribers = $counters->totalCounter->subscribers;

        return $userProfile;
    }

    /**
     * @param User $user
     *
     * @return Counters
     */
    public function constructCounters(User $user): Counters
    {
        $counters = new Counters();

        $counters->twitchCounter = $this->getTwitchCounters($user);

        $counters->youtubeCounter = $this->getYoutubeCounters($user);

        $counters->totalCounter = new Counter();

        $counters->totalCounter->followers = $counters->twitchCounter->followers + $counters->youtubeCounter->followers;
        $counters->totalCounter->views = $counters->twitchCounter->views + $counters->youtubeCounter->views;
        $counters->totalCounter->subscribers = $counters->twitchCounter->subscribers + $counters->youtubeCounter->subscribers;

        return $counters;
    }

    /**
     * @param User $user
     *
     * @return Counter
     */

    public function getTwitchCounters(User $user): Counter
    {
        $twitchCounter = new Counter();

        if ($user->twitch_id)
        {
            $twitchData = TwitchService::getInstance()->getDataByUserID($user->twitch_id);

            $twitchCounter->followers = $twitchData->followers;
            $twitchCounter->views = $twitchData->views;
            $twitchCounter->subscribers = $twitchData->subscribers;
        }

        return $twitchCounter;
    }

    /**
     * @param User $user
     *
     * @return Counter
     */
    public function getYoutubeCounters(User $user): Counter
    {
        $youtubeCounter = new Counter();

        if ($user->youtube_id)
        {
            $youtubeData = YouTubeService::getInstance()->getDataByUserID($user->youtube_id);

            $youtubeCounter->followers = $youtubeData->followers;
            $youtubeCounter->views = $youtubeData->views;
            $youtubeCounter->subscribers = $youtubeData->subscribers;
        }

        return $youtubeCounter;
    }

    /**
     * @param ?int $user_id
     *
     * @return FriendProfile[]
     */
    public function getFriendProfileList(?int $user_id = null): array
    {
        if (!$user_id) $user_id = $this->getCurrentUserId();

        $friendsProfileList = [];

        $friends = $this->friendRepository->findFriendsIdsByUserId($user_id);

        foreach ($friends as $friend) {
            $userProfile = $this->getUserProfile($friend->friend_id);

            $friendsProfile = new FriendProfile();

            $friendsProfile->id = $userProfile->id;
            $friendsProfile->nickname = $userProfile->nickname;
            $friendsProfile->followers = $userProfile->followers;

            $friendsProfileList[] = $friendsProfile;
        }

        return $friendsProfileList;
    }
}