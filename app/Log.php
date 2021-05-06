<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'type',
        'action',
    ];

    public static function createLog($type, $action) {
        $log = new self;
        $log->type = $type;
        $log->action = $action;
        $log->save();
        return $log->id;
    }
}
