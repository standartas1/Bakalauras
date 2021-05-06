<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'type_id',
        'information',
        'file_id',
        'price_self',
        'price',
        'profit',
        'client_id',
        'subtype_id',
    ];

    public function file()
    {
        return $this->belongsTo('App\File');
    }

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function subtype()
    {
        return $this->belongsTo('App\Subtype');
    }
}
