<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class form extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'date',
        'postcode',
        'straatnaam',
        'huisnummer',
        // 'toevoeging',
        'phone_number',
        'message',
    ];
}
