<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommercialRoom extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'capacity'];
    protected $guarded = ['id', 'created_at', 'update_at', 'deleted_at'];
    protected $table = 'commercial_room';

    public function schedules()
    {
        return $this->hasMany(Schedules::class);
    }
}
