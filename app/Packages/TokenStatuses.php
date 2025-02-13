<?php

namespace App\Packages;

/**
 * Class TokenStatuses.
 *
 * @package App\Packages
 *
 */
class TokenStatuses
{
    const NOT_FOUND = 0;
    const EXPIRED = 1;
    const USED = 2;

    /**
     *
     *
     * @var array
     */
    protected static $STATUSES = [
        self::NOT_FOUND => 'not_found',
        self::EXPIRED => 'expired',
        self::USED => 'used'

    ];

    /**
     *
     * @param bool $returnKey
     *
     * @return array|int|string
     */
    public static function notFound($returnKey = false)
    {
        return ($returnKey) ? 0: static::all(0);
    }

    /**
     *
     * @param bool $returnKey
     *
     * @return array|int|string
     */
    public static function expired($returnKey = false)
    {
        return ($returnKey) ? 1: static::all(1);
    }

    /**
     *
     * @param bool $returnKey
     *
     * @return array|int|string
     */
    public static function used($returnKey = false)
    {
        return ($returnKey) ? 2: static::all(2);
    }

    /**
    *
    * @param int $type
    *
    * @return array
    */
    public static function all($type = null)
    {
        if ((!is_null($type) && !array_key_exists($type, self::$STATUSES)) || is_null($type)) {
            return self::$STATUSES;
        }

        return  self::$STATUSES[$type];
    }


}
