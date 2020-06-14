<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clients extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','email','phone'];
    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'clients';
}
