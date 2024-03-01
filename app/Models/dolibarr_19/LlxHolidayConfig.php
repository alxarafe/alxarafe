<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHolidayConfig
 *
 * @property int $rowid
 * @property string $name
 * @property string|null $value
 *
 * @package App\Models
 */
class LlxHolidayConfig extends Model
{
	protected $table = 'llx_holiday_config';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'value'
	];
}
