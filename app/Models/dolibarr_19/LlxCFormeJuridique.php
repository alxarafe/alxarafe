<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCFormeJuridique
 *
 * @property int $rowid
 * @property int $code
 * @property int $fk_pays
 * @property string|null $libelle
 * @property int $isvatexempted
 * @property int $active
 * @property string|null $module
 * @property int $position
 *
 * @package App\Models
 */
class LlxCFormeJuridique extends Model
{
	protected $table = 'llx_c_forme_juridique';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'code' => 'int',
		'fk_pays' => 'int',
		'isvatexempted' => 'int',
		'active' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'code',
		'fk_pays',
		'libelle',
		'isvatexempted',
		'active',
		'module',
		'position'
	];
}
