<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * WaitingList model class
 *
 * @property int $id
 * @property string $player_name
 * @property Carbon $added_at
 * @property Carbon|null $removed_at
 * @property int $group_number
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WaitingList extends Model
{
    use HasFactory;

    protected $table = 'waiting_lists';

    protected $guarded =
        [
            'id',
            'created_at',
            'updated_at',
        ];

    protected $fillable =
        [
            'player_name',
            'added_at',
            'removed_at',
            'group_number',
        ];
}
