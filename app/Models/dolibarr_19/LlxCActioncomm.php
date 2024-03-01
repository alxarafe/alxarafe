<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCActioncomm
 *
 * @property int $id
 * @property string $code
 * @property string $type
 * @property string $libelle
 * @property string|null $module
 * @property int $active
 * @property int|null $todo
 * @property string|null $color
 * @property string|null $picto
 * @property int $position
 *
 * @package App\Models
 */
class LlxCActioncomm extends Model
{
	protected $table = 'llx_c_actioncomm';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'active' => 'int',
		'todo' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'code',
		'type',
		'libelle',
		'module',
		'active',
		'todo',
		'color',
		'picto',
		'position'
	];
}
