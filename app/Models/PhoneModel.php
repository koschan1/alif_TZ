<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneModel extends Model
{
    public $timestamps = false;
    protected $table = 'contact_phones';
    protected $fillable = [
        "contact_id",
        "phone"
    ];

    protected $hidden = [
        "id",
        "contact_id",
        "user_id",
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
