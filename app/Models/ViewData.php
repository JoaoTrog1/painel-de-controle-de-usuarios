<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewData extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'content',
        'min',
        'max',
        'link',
    ];
}

