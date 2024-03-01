<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCEffectif
 *
 * @property int $id
 * @property string $code
 * @property string|null $libelle
 * @property int $active
 * @property string|null $module
 *
 * @package App\Models
 */
class LlxCEffectif extends Model
{
	protected $table = 'llx_c_effectif';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'libelle',
		'active',
		'module'
	];
}
