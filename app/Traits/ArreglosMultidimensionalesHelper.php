<?php

namespace App\Traits;

trait ArreglosMultidimensionalesHelper
{
    
    public static function sonIguales($a, $b, bool $is_strict = true): bool
    {
        // check PHP evaluation first
        if ($is_strict ? ($a === $b) : ($a == $b)) {
            return true;
        }

        // comparing scalar is done above, now recursive array comparison
        if (! is_array($a) || ! is_array($b)) {
            return false;
        }

        foreach ([[$a, $b], [$b, $a]] as [$x, $y]) {
            foreach ($x as $xkey => $xval) {
                if (! array_key_exists($xkey, $y)) {
                    return false;
                }

                if (! self::sonIguales($xval, $y[$xkey], $is_strict)) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function arrayFilterRecursive($array, $callback = null, $removeEmptyArrays = false)
    {
        foreach ($array as $key => & $value) { // mind the reference
            if (is_array($value)) {
                $value = self::arrayFilterRecursive($value, $callback, $removeEmptyArrays);
                if ($removeEmptyArrays && ! (bool) $value) {
                    unset($array[$key]);
                }
            } else {
                if (! is_null($callback) && ! $callback($value, $key)) {
                    unset($array[$key]);
                } elseif (! (bool) $value) {
                    unset($array[$key]);
                }
            }
        }
        unset($value); // kill the reference
        return $array;
    }
}
