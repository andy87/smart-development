<?php

namespace services\items;

use components\core\{BaseModel, BaseService};
use models\dto\Counters;
use models\dto\counters\Counter;
use models\dto\profile\FriendProfile;
use models\dto\profile\UserProfile;
use models\User;
use repository\FriendRepository;
use repository\UserRepository;
use services\TwitchService;
use services\YouTubeService;

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

        $user = $this->findItemByCriteria(['id' => $user_id]);

        return ($user) ? $this->constructUserProfile($user) : null;
    }

    /**
     * @return int
     */
    public function getCurrentUserId(): int
    {
        return 1;
    }

    /**
     * @param array $criteria
     *
     * @return ?User
     */
    private function findItemByCriteria(array $criteria): ?User
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
        $userProfile->avatar = $_ENV['path_upload_avatar'] . $user->avatar;

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
    private function constructCounters( User $user): Counters
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
    private function getTwitchCounters( User $user ): Counter
    {
        $twitchData = TwitchService::getInstance()->getDataByUserID($user->id);

        $twitchCounter = new Counter();

        $twitchCounter->followers = $twitchData['followers'];
        $twitchCounter->views = $twitchData['views'];
        $twitchCounter->subscribers = $twitchData['subscribers'];

        return $twitchCounter;
    }

    /**
     * @param User $user
     *
     * @return Counter
     */
    public function getYoutubeCounters(User $user): Counter
    {
        $youtubeData = YouTubeService::getInstance()->getDataByUserID($user->id);

        $youtubeCounter = new Counter();

        $youtubeCounter->followers = $youtubeData['followers'];
        $youtubeCounter->views = $youtubeData['views'];
        $youtubeCounter->subscribers = $youtubeData['subscribers'];

        return $youtubeCounter;
    }

    /**
     * @param ?int $user_id
     *
     * @return FriendProfile[]
     */
    public function getFriendProfileList( ?int $user_id = null): array
    {
        if (!$user_id) $user_id = $this->getCurrentUserId();

        $friendsProfileList = [];

        $friends = $this->friendRepository->findFriendsIdsByUserId($user_id);

        foreach ($friends as $friend)
        {
            $userProfile = $this->getUserProfile($friend['friend_id']);

            $friendsProfile = new FriendProfile();

            $friendsProfile->id = $userProfile->id;
            $friendsProfile->nickname = $userProfile->nickname;
            $friendsProfile->followers = $userProfile->followers;

            $friendsProfileList[] = $friendsProfile;
        }

        return $friendsProfileList;
    }
}