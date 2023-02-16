<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'user_contacts';
    protected $fillable = [
        "name",
        "user_id",
        "date_of_birth"
    ];

    protected $hidden = [
        "user_id",
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];

    public function phoneUser(){
        return $this->hasMany(PhoneModel::class);
    }

    public function emailUser(){
        return $this->hasMany(EmailModel::class);
    }

}
