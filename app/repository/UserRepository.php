<?php

namespace repository;

use components\core\repository\BaseYiiRepository;
use models\User;

/**
 *  Class UserRepository
 *
 * @package repository
 *
 * @tag #repository #user
 */
class UserRepository extends BaseYiiRepository
{
    private const CLASS_MODEL = User::class;

    /**
     * @return User|string
     *
     * @tag #get
     */
    public function getClass(): User|string
    {
        /** @var User|string $class */
        $class = self::CLASS_MODEL;

        return $class;
    }

    /**
     * @param array $criteria
     *
     * @return ?User
     *
     * @tag #find #find-model
     */
    public function findItemByCriteria(array $criteria): ?User
    {
        $query = $this->find()->where($criteria);

        /** @var ?User $user */
        $user = $query->one();

        return $user;
    }

    public function getFriendIdList(int $getCurrentUserId)
    {
        $friendRepository = new FriendRepository();

        $query = $this->find()->where(['id' => $getCurrentUserId]);

        $user = $query->one();

        return $user->getFriendIdList();
    }
}