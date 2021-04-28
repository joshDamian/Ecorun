<?php

namespace App\Models\Information\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentlyViewed extends Model
{
    use HasFactory;

    public function viewable()
    {
        return $this->morphTo();
    }

    /* public function product()
    {
        return $this->belongsTo(Product::class);
    }
 */
    /* public function user()
    {
        return $this->belongsTo(User::class);
    } */
}
