<?php

namespace App\Presenters\User;

use App\Models\User;
use App\Presenters\Presenter;

class UrlPresenter
{
    use Presenter;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function cart()
    {
        return route('cart.index');
    }
}
