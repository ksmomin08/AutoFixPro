<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['name', 'bike', 'text', 'stars', 'initials', 'is_visible'];
}
