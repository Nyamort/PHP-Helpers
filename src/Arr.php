<?php
namespace IERomain;

use ArrayAccess;

class Arr
{
    /**
     *  group an array by a field.
     * @param  array   $array
     * @param  string  $key
     *
     * @return array
     */
    public static function array_groupBy(array $array, string $key): array
    {
        $result = [];
        foreach ($array as $element) {
            $result[$element[$key]][] = $element;
        }
        return $result;
    }

    /**
     * get the first element of an array.
     * @param  array          $array
     * @param  callable|null  $callback
     *
     * @return array|null
     */
    public static function array_first(array $array, callable $callback = null): ?array
    {
        if (is_null($callback)) {
            return reset($array);
        }

        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * flatten an array.
     * @param  array  $array
     *
     * @return array
     */
    public static function array_flatten(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, static::array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Get a value from the array using "dot" notation.
     *
     * @param  array        $target
     * @param  string|null  $key
     * @param               $default
     *
     * @return array|mixed|null
     */
    public static function array_get(array $target, ?string $key, $default = null): mixed
    {
        if (!$key) return $target;

        $keys = explode('.', $key, 2);
        $key = $keys[0];
        $keys = $keys[1] ?? NULL;

        if ($keys === NULL) {
            if (array_key_exists($key, $target)) return $target[$key];
            else if ($key === '*') {
                $result = [];
                foreach ($target as $k => $v) {
                    $result[] = $v;
                }
                return $result === [] ? $default : $result;
            } else return $default;
        } else {
            if (array_key_exists($key, $target)) {
                if (self::array_accessible($target[$key])) return self::array_get($target[$key], $keys, $default);
                else return $default;
            } else if ($key === '*') {
                $result = [];
                foreach ($target as $k => $v) {
                    if (self::array_accessible($v)) $result = array_merge($result, self::array_get($v, $keys, $default));
                }
                return $result === [] ? $default : $result;
            } else return $default;
        }
    }

    /**
     * Determine whether the given value is array accessible.
     * @param $value
     *
     * @return bool
     */
    public static function array_accessible($value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Determine whether the key exists in the array.
     * @param $array
     * @param $key
     *
     * @return bool
     */
    public static function array_exists($array, $key): bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * Collapse an array of arrays into a single array.
     * @param  iterable  $array
     *
     * @return array
     */
    public static function array_collapse(iterable $array): array
    {
        $results = [];
        foreach ($array as $values) {
            if (!is_array($values)) {
                continue;
            }

            $results[] = $values;
        }

        return array_merge([], ...$results);
    }
}
