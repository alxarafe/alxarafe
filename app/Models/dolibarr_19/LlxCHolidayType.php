<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCHolidayType
 *
 * @property int $rowid
 * @property string $code
 * @property string $label
 * @property int $affect
 * @property int $delay
 * @property float $newbymonth
 * @property int|null $fk_country
 * @property int $block_if_negative
 * @property int|null $sortorder
 * @property int|null $active
 *
 * @package App\Models
 */
class LlxCHolidayType extends Model
{
	protected $table = 'llx_c_holiday_types';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'affect' => 'int',
		'delay' => 'int',
		'newbymonth' => 'float',
		'fk_country' => 'int',
		'block_if_negative' => 'int',
		'sortorder' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'affect',
		'delay',
		'newbymonth',
		'fk_country',
		'block_if_negative',
		'sortorder',
		'active'
	];
}
