<?php

namespace Dkp\Seat\SeatDKP\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Seat\Services\Traits\NotableTrait;


class DkpSupplement extends Model
{
    use NotableTrait;
    use Notifiable;

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $table = 'dkp_supplement';

    protected $fillable = ['id', 'supplement_name', 'all_dkp', 'use_dkp', 'supplement_num', 'is_use', 'remark',];

}