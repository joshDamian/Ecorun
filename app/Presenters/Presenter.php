<?php

namespace App\Presenters;

trait Presenter
{
    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return (property_exists($this, $key)) ? $this->$key : null;
    }
}
