<?php
namespace App\Models\Implementations;
interface RedisKey
{
    /**
     * Summary of firstKey
     * @param mixed $fk first key
     * @return mixed value of firstKey in Redis
     */
    public static function firstKey($fk);
    /**
     * Summary of secondKey
     * @param mixed $sk second Key
     * @return mixed  value of secondKey in Redis
     * the second Key represent value of category id 
     */
    public static function secondKey($sk);
}
