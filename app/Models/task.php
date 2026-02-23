<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'is_done'];

    protected $casts = [
        'is_done' => 'boolean' ,
    ];
}
