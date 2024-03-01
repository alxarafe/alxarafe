<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCTypeContainer
 *
 * @property int $rowid
 * @property string $code
 * @property int $entity
 * @property string $label
 * @property string|null $module
 * @property int|null $position
 * @property int $active
 *
 * @package App\Models
 */
class LlxCTypeContainer extends Model
{
	protected $table = 'llx_c_type_container';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'position' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'entity',
		'label',
		'module',
		'position',
		'active'
	];
}
