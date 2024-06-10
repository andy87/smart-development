<?php

namespace repository;

use models\sources\Friend;
use components\core\BaseRepository;

/**
 * Class FriendRepository
 *
 * @package repository
 */
class FriendRepository extends BaseRepository
{
    /**
     * @return Friend|string
     */
    private function getClass(): Friend|string
    {
        return Friend::class;
    }

    /**
     * @tag #find
     */
    public function find()
    {
        return $this->getClass()::find();
    }

    /**
     * @param int $userId
     *
     * @return Friend[]
     */
    public function findFriendsIdsByUserId(int $userId): array
    {
        $query = $this->find()
            ->select(Friend::ATTR_FRIEND_ID)
            ->where([Friend::ATTR_USER_ID => $userId]);

        /** @var ?array $friends */
        $friends = $query->all();

        return $friends;
    }

}