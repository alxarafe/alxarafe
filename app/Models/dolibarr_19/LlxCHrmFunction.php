<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCHrmFunction
 *
 * @property int $rowid
 * @property int $pos
 * @property string $code
 * @property string|null $label
 * @property int $c_level
 * @property int $active
 *
 * @package App\Models
 */
class LlxCHrmFunction extends Model
{
	protected $table = 'llx_c_hrm_function';
	protected $primaryKey = 'rowid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'rowid' => 'int',
		'pos' => 'int',
		'c_level' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'pos',
		'code',
		'label',
		'c_level',
		'active'
	];
}
