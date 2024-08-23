<?php
namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Request;

class RedisController extends Controller
{
    /**
     * Retrieve data from Redis or compute and store it if not present.
     *
     * @param mixed $key The key to look up in Redis.
     * @param callable $getFrom A callable to run if the key does not exist.
     * @return mixed The value from Redis or the result of the callable.
     */
    public static function get($key, callable $getFrom)
    {
        // Check if the key exists in Redis
        $val = Redis::get($key);
        if (!empty($val)) {
            return unserialize($val);
        }

        // If not, call the provided function to get the data
        $val = $getFrom();

        // Set the value in Redis asynchronously
        self::set($key, $val);

        return $val;
    }//checked

    /**
     * Set a value in Redis asynchronously.
     *
     * @param mixed $key The key to set in Redis.
     * @param mixed|callable $value The value to set.
     * @return void
     */
    public static function set($key, $value)
    {
        if (is_callable($value)) {
            $value = $value();
        }

        // serialize the value before storing it
        $serializedValue = serialize($value);
        Redis::set($key, $serializedValue);
    }//checked
    /**
     * Retrieve data from Redis or compute and store it if not present.
     *
     * @param mixed $firstkey The key to look up in Redis.
     * @param mixed $secondkey The key to look up in Redis.
     * @param callable $getFrom A callable to run if the key does not exist.
     * @return mixed The value from Redis or the result of the callable.
     */
    public static function hget($firstkey, $secondkey, callable $getFrom)
    {
        // Check if the key exists in Redis
        $val = Redis::hget($firstkey, $secondkey);
        if (!empty($val)) {
            return unserialize($val);
        }

        // If not, call the provided function to get the data
        $val = $getFrom();

        // Set the value in Redis asynchronously
        self::hset($firstkey, $secondkey, $val);
        return $val;
    }

    /**
     * Set a value in Redis asynchronously.
     *
     * @param mixed $firstkey,$secondkey The key to set in Redis.
     * @param mixed $secondkey,$secondkey The key to set in Redis.
     * @param bool|null  $now,determen wthere it's will run queue or now
     * @param mixed|callable $value The value to set.
     * @return void
     */
    public static function hset($firstkey, $secondkey, $value)
    {
        if (is_callable($value)) {
            $value = $value();
        }
        $serializedValue = serialize($value);
        Redis::hset(
            $firstkey,
            $secondkey,
            $serializedValue,
        );
        return;
        // \App\Jobs\HSetRedisValue::dispatch($firstkey, $secondkey, $serializedValue);
    }

    /**
     * Summary of hgetall
     * 
     * @param mixed $firstKey get all value of this key
     * @param callable $getFrom if not exist in redis get From and assigne it to redis
     * @return array|\Illuminate\Database\Eloquent\Collection $values
     */
    public static function hgetall($firstKey, $getFrom)
    {
        $values = Redis::hgetall($firstKey);
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                $values[$key] = unserialize($value);
            }
            return $values;
        }
        $values = $getFrom();
        self::hsetall($firstKey, $values);
        return $values;

    }

    /**
     * Set a values in Redis hash .
     * @param mixed $firstkey, The key to set values in.
     * @param array|\Illuminate\Database\Eloquent\Collection $value array Or Collection of value each one of them must
     *  include id cuase it will be the secondKey to access on it ,
     *  if there id dosn't exist the second key will be .
     * @return void 
     */
    public static function hsetall($firstkey, $values): void
    {
        $ids = [];
        foreach ($values as $value) {
            $id = $value->id;
            $ids[] = $id;
            if (empty($id)) {
                $id = $value[0];
            }
            self::hset($firstkey, $id, $value);
        }
        dd($ids);
    }
}
