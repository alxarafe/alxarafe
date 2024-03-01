<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCTypent
 *
 * @property int $id
 * @property string $code
 * @property string|null $libelle
 * @property int|null $fk_country
 * @property int $active
 * @property string|null $module
 * @property int $position
 *
 * @package App\Models
 */
class LlxCTypent extends Model
{
	protected $table = 'llx_c_typent';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'fk_country' => 'int',
		'active' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'code',
		'libelle',
		'fk_country',
		'active',
		'module',
		'position'
	];
}
