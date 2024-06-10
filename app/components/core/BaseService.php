<?php

namespace components\core;

/**
 * Class BaseService
 *
 * @package components\core
 */
abstract class BaseService
{
    private static array $singleton = [];

    protected BaseModel|string $classModel;



    /**
     * @param array $config
     *
     * @return static|string
     */
    public static function getInstance( array $config = []): static|string
    {
        $classname = static::class;

        if ( !isset(self::$singleton[ $classname ]) ) {
            self::$singleton[ $classname ] = new $classname( ...$config );
        }

        return self::$singleton[ $classname ];
    }


    /**
     * @return BaseModel|string
     */
    public function getClassModel(): BaseModel|string
    {
        return $this->classModel;
    }

    /**
     * @param array $attributes
     *
     * @return BaseModel|string
     */
    public function getModel( array $attributes = [] ): BaseModel|string
    {
        $className = $this->classModel;

        return new $className($attributes);
    }

}