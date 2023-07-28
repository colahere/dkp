<?php

namespace Dkp\Seat\SeatDKP\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Seat\Services\Traits\NotableTrait;


class DkpInfo extends Model
{
    use NotableTrait;
    use Notifiable;

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $table = 'dkp_info';

    protected $fillable = ['id', 'user_id', 'character_id', 'score', 'status', 'remark', 'approved', 'supplement_id', 'approver',];

}