<?php

namespace App\Presenters\Service;

use App\Presenters\Presenter;
use App\Models\Buy\Service\Service;

class UrlPresenter
{
    use Presenter;

    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function show(): string
    {
        return "";
    }
}
