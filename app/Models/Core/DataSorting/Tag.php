<?php

namespace App\Models\Core\DataSorting;

use Spatie\Tags\Tag as Model;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use Searchable;
}
