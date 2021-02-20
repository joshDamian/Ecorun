<?php

namespace App\Presenters\User;

use App\Models\User;

class UrlPresenter
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->$key();
        }
        return $this->$key;
    }

    public function cart()
    {
        return route('cart.index');
    }
}
