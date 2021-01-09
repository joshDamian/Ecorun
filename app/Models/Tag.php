<?php

namespace App\Models;

use Spatie\Tags\Tag as Model;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use Searchable;

}