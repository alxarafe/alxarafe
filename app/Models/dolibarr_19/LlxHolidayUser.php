<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHolidayUser
 *
 * @property int $fk_user
 * @property int $fk_type
 * @property float $nb_holiday
 *
 * @package App\Models
 */
class LlxHolidayUser extends Model
{
	protected $table = 'llx_holiday_users';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_user' => 'int',
		'fk_type' => 'int',
		'nb_holiday' => 'float'
	];

	protected $fillable = [
		'nb_holiday'
	];
}
