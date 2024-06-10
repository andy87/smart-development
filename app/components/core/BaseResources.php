<?php

namespace components\core;

/**
 * Class BaseResources
 *
 * @package components\core
 */
abstract class BaseResources
{
    /** @var string  */
    protected const KEY = 'R';

    /**
     * @return BaseResources[]
     */
    public function release(): array
    {
        return [
            self::KEY => $this
        ];
    }
}