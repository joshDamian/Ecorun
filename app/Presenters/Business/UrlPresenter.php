<?php

declare(strict_types=1);

namespace App\Presenters\Business;

use App\Models\Build\Business\Business;
use App\Presenters\Presenter;

class UrlPresenter
{
    use Presenter;

    private Business $business;
    private $business_url;

    public function __construct(Business $business)
    {
        $this->business = $business;
        $this->business_url = $this->business->profile->url->business_url;
    }

    public function warehouse(): string
    {
        return $this->business_url . '/warehouse';
    }

    public function sell(): string
    {
        return $this->business_url . '/sell';
    }

    public function team(): string
    {
        return $this->business_url . '/team';
    }

    public function orders(): string
    {
        return $this->business_url . '/orders';
    }
}
