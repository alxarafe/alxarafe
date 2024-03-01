<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHolidayLog
 *
 * @property int $rowid
 * @property Carbon $date_action
 * @property int $fk_user_action
 * @property int $fk_user_update
 * @property int $fk_type
 * @property string $type_action
 * @property string $prev_solde
 * @property string $new_solde
 *
 * @package App\Models
 */
class LlxHolidayLog extends Model
{
	protected $table = 'llx_holiday_logs';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_action' => 'datetime',
		'fk_user_action' => 'int',
		'fk_user_update' => 'int',
		'fk_type' => 'int'
	];

	protected $fillable = [
		'date_action',
		'fk_user_action',
		'fk_user_update',
		'fk_type',
		'type_action',
		'prev_solde',
		'new_solde'
	];
}
