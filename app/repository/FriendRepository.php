<?php

namespace repository;

use components\core\BaseRepository;

class FriendRepository extends BaseRepository
{
    private function getClass()
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
     * @return array
     */
    public function findFriendsIdsByUserId(int $userId): array
    {
        $query = $this->find()
            ->select('friend_id')
            ->where(['user_id' => $userId]);

        /** @var ?array $friends */
        $friends = $query->all();

        return $friends;
    }

}