<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

trait WithCache
{
    public function setCache($key, $valor, $time = null): bool
    {
        $key .= '-' . Auth::id() ?? Session::getId();
        if (empty($time)) {
            $time = now()->addMinutes('30');
        }
        return Cache::put("{$key}", $valor, $time);
    }

    public function getCache($key)
    {
        $key .= '-' . Auth::id() ?? Session::getId();
        $value = null;
        if (Cache::has($key)) {
            $value = Cache::get($key);
        }
        return $value;
    }

    public function deleteCache(array $keys): void
    {
        foreach ($keys as $key) {
            $key .= '-' . Auth::id() ?? Session::getId();
            Cache::forget($key);
        }
    }
}
