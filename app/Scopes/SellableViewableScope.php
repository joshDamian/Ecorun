<?php

namespace App\Scopes;

use App\Models\Build\Sellable\Product\Product;
use App\Models\Buy\Service\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SellableViewableScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereExists(function ($query) {
            $query->select('*')->from('images')->where(function ($query) {
                $query->where('images.imageable_type', Product::class)->orWhere('images.imageable_type', Service::class);
            })->whereRaw('images.imageable_id = sellables.sellable_id');
        });
    }
}
