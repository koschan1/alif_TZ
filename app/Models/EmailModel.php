<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailModel extends Model
{
    public $timestamps = false;
    protected $table = 'contact_emails';
    protected $fillable = [
        "contact_id",
        "email"
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
