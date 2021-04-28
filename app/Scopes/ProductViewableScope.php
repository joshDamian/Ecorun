<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ProductViewableScope implements Scope
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
            $query->select('*')
                ->from('images')
                ->where('images.imageable_type', 'App\Models\Build\Sellable\Product\Product')
                ->whereRaw('images.imageable_id = products.id');
        });
    }
}
