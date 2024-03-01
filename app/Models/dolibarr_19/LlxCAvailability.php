<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCAvailability
 *
 * @property int $rowid
 * @property string $code
 * @property string $label
 * @property string|null $type_duration
 * @property float|null $qty
 * @property int $active
 * @property int $position
 *
 * @package App\Models
 */
class LlxCAvailability extends Model
{
	protected $table = 'llx_c_availability';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'qty' => 'float',
		'active' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'type_duration',
		'qty',
		'active',
		'position'
	];
}
