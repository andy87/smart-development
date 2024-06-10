<?php

namespace components\core;

abstract class BaseApiResponse
{
    /**
     * @param static $response
     * @param array $data
     *
     * @return static
     */
    public static function constructItem(self $response, array $data): static
    {
        foreach ($data as $key => $value) {
            if (property_exists($response, $key) && $value) {
                $response->$key = $value;
            }
        }

        return $response;
    }
}