<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCHrmDepartment
 *
 * @property int $rowid
 * @property int $pos
 * @property string $code
 * @property string|null $label
 * @property int $active
 *
 * @package App\Models
 */
class LlxCHrmDepartment extends Model
{
	protected $table = 'llx_c_hrm_department';
	protected $primaryKey = 'rowid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'rowid' => 'int',
		'pos' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'pos',
		'code',
		'label',
		'active'
	];
}
