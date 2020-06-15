<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedules extends Model
{
    use SoftDeletes;

    protected $fillable = ['clients_id', 'commercial_room_id', 'observation', 'schedule_date'];
    protected $guarded = ['id', 'created_at', 'update_at', 'deleted_at'];
    protected $table = 'schedules';

    public function clients()
    {
        return $this->belongsTo(Clients::class);
    }

    public function commercialRoom()
    {
        return $this->belongsTo(CommercialRoom::class);
    }
}
