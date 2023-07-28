<?php

namespace Dkp\Seat\SeatDKP\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Seat\Services\Traits\NotableTrait;


class DkpConfig extends Model
{
    use NotableTrait;
    use Notifiable;

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $table = 'dkp_config';

    protected $fillable = ['id', 'name', 'level', 'score', 'station', 'ship_num', 'label',];

}