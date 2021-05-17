<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait StringManipulations
{
    public function data_slug(string $key = null): string|null|array
    {
        if ($key && is_string($this->{$key})) {
            $result = Str::slug($this->{$key});
        } else {
            $result = [];
            foreach (get_object_vars($this) as $key => $value) {
                if (is_string($value)) {
                    $result[$key] = Str::slug($value);
                    continue;
                }
            }
        }
        return $result ?? null;
    }

    public function singular(string $key = null): string|null|array
    {
        if ($key && is_string($this->{$key})) {
            $result = Str::singular($this->{$key});
        } else {
            $result = [];
            foreach (get_object_vars($this) as $key => $value) {
                if (is_string($value)) {
                    $result[$key] = Str::singular($value);
                    continue;
                }
            }
        }
        return $result ?? null;
    }
}
