<?php

namespace App\Packages;

use App\Models\Affiliate;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Softwareowner;
/**
 * Class Account.
 *
 * @package App\Packages
 *
 */
class AccountType
{
    const AFFILIATE = 0;
    const EMPLOYEE = 1;
    const CUSTOMER = 2;
    const SOFTWAREOWNER = 3;
    const BRAND = 4;

    /**
     *
     *
     * @var array
     */
    protected static $ACCOUNTS = [
        self::AFFILIATE => 'affiliate',
        self::EMPLOYEE => 'employee',
        self::CUSTOMER => 'customer',
        self::SOFTWAREOWNER => 'softwareowner',
        self::BRAND => 'brand',

    ];

    /**
     *
     *
     * @var array
     */
    protected static $CLASSES = [
        self::AFFILIATE => Affiliate::class,
        self::EMPLOYEE => Employee::class,
        self::CUSTOMER => Customer::class,
        self::SOFTWAREOWNER => Softwareowner::class,
        self::BRAND => Brand::class
    ];


    /**
     *
     * @param bool $returnKey
     *
     * @return array|int|string
     */
    public static function affiliate($returnKey = false, $returnClassName = false)
    {
        if ($returnClassName) {
            return static::classes(0);
        }
        return ($returnKey) ? 0: static::all(0);
    }

    /**
     *
     * @param bool $returnKey
     *
     * @return array|int|string
     */
    public static function brand($returnKey = false, $returnClassName = false)
    {
        if ($returnClassName) {
            return static::classes(0);
        }
        return ($returnKey) ? 4: static::all(4);
    }

    /**
     *
     * @param bool $returnKey
     *
     * @return array|int|string
     */
    public static function employee($returnKey = false, $returnClassName = false)
    {
        if ($returnClassName) {
            return static::classes(1);
        }
        return ($returnKey) ? 1 : static::all(1);
    }

    /**
     *
     * @param bool $returnKey
     *
     * @return array|int|string
     */
    public static function customer($returnKey = false, $returnClassName = false)
    {
        if ($returnClassName) {
            return static::classes(2);
        }
        return ($returnKey) ? 2 : static::all(2);
    }

    /**
     *
     * @param bool $returnKey
     *
     * @return array|int|string
     */
    public static function softwareowner($returnKey = false, $returnClassName = false)
    {
        if ($returnClassName) {
            return static::classes(3);
        }
        return ($returnKey) ? 3 : static::all(3);
    }

    /**
    *
    * @param int $account type
    *
    * @return array
    */
    public static function all($type = null)
    {
        if ((!is_null($type) && !array_key_exists($type, self::$ACCOUNTS)) || is_null($type)) {
            return self::$ACCOUNTS;
        }

        return  self::$ACCOUNTS[$type];
    }

    /**
    *
    * @param int $account type
    *
    * @return array
    */
    public static function classes($type = null)
    {
        if ((!is_null($type) && !array_key_exists($type, self::$CLASSES)) || is_null($type)) {
            return self::$CLASSES;
        }

        return  self::$CLASSES[$type];
    }

    /**
    *
    * @param string $account name
    *
    * @return int
    */
    public static function findIdByName(string $name)
    {
        return array_search($name,self::$ACCOUNTS);
    }


    /**
    * @param string $account name
    *
    * @return int
    */
    public static function findClassNameByShortName(string $name)
    {
        return (array_search($name,self::$ACCOUNTS) !== null) ? self::$CLASSES[array_search($name,self::$ACCOUNTS)] : null;
    }

}
