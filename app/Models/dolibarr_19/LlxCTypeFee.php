<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCTypeFee
 *
 * @property int $id
 * @property string $code
 * @property string|null $label
 * @property int|null $type
 * @property string|null $accountancy_code
 * @property int $active
 * @property string|null $module
 * @property int $position
 *
 * @package App\Models
 */
class LlxCTypeFee extends Model
{
	protected $table = 'llx_c_type_fees';
	public $timestamps = false;

	protected $casts = [
		'type' => 'int',
		'active' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'type',
		'accountancy_code',
		'active',
		'module',
		'position'
	];
}
