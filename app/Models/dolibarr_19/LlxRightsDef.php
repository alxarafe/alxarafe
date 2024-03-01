<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxRightsDef
 *
 * @property int $id
 * @property string|null $libelle
 * @property string|null $module
 * @property int $module_position
 * @property int $family_position
 * @property int $entity
 * @property string|null $perms
 * @property string|null $subperms
 * @property string|null $type
 * @property int|null $bydefault
 *
 * @package App\Models
 */
class LlxRightsDef extends Model
{
	protected $table = 'llx_rights_def';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'module_position' => 'int',
		'family_position' => 'int',
		'entity' => 'int',
		'bydefault' => 'int'
	];

	protected $fillable = [
		'libelle',
		'module',
		'module_position',
		'family_position',
		'perms',
		'subperms',
		'type',
		'bydefault'
	];
}
