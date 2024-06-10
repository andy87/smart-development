<?php

namespace components\core\repository;

use components\core\BaseModel;
use components\core\BaseRepository;

/**
 * Class BaseRepository
 *
 * @package components\core
 */
abstract class BaseYiiRepository extends BaseRepository
{
    abstract public function getClass(): BaseModel|string;

    /**
     * @tag #find
     */
    public function find()
    {
        return $this->getClass()::find();
    }

}