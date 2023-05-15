<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{



    protected $fillable = [

        'type',

        'notification_for',

        'user_id',

        'title',

        'read_at',

    ];
}
