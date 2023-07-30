<?php

namespace Dkp\Seat\SeatDKP\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Seat\Services\Traits\NotableTrait;


class DkpQQ extends Model
{
    use NotableTrait;
    use Notifiable;

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $table = 'dkp_QQ';

    protected $fillable = ['id','user_id','QQ',];

}