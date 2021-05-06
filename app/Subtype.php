<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtype extends Model
{
    protected $table = 'subtypes';
    protected $fillable = [
        'name',
    ];
}
