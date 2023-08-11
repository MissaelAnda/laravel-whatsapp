<?php

namespace MissaelAnda\Whatsapp;

use Illuminate\Support\Arr;
use MissaelAnda\Whatsapp\Exceptions\MalformedPayloadException;

abstract class Utils
{
    public static function extract(array $payload, string|array $path): mixed
    {
        $results = [];
        foreach ((array)$path as $p) {
            if (!Arr::has($payload, $p)) {
                throw new MalformedPayloadException($p);
            }

            $results[] = Arr::get($payload, $p);
        }

        return count($results) === 1 ? $results[0] : $results;
    }
}
