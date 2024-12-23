<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    use HasFactory;
    protected $table = 'apps';

    protected $fillable = ['nome', 'f1', 'f2', 'comando'];
}

