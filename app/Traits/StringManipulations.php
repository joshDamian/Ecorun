<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait StringManipulations
{
    public function data_slug(string $key = null)
    {
        if ($key) {
            $result = Str::of($this->slugData()[$key])->slug('-')->__toString();
        } else {
            $result = [];

            foreach ($this->slugData() as $array_key => $value) {
                $result[$array_key] = Str::of($value)->slug('-')->__toString();
            }
        }

        return $result;
    }

    public function singular(string $key = null)
    {
        if ($key) {
            $result =
                Str::of($this->canBeSingular()[$key])->singular()->__toString();
        } else {
            $result = [];

            foreach ($this->canBeSingular() as $array_key => $value) {
                $result[$array_key] = Str::of($value)->singular()->__toString();
            }
        }

        return $result;
    }
}
