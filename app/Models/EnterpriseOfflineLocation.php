<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterpriseOfflineLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'city', 'state', 'address_line', 'label'
    ];

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }
}
