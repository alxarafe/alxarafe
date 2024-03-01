<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCPaiement
 *
 * @property int $id
 * @property int $entity
 * @property string $code
 * @property string|null $libelle
 * @property int|null $type
 * @property int $active
 * @property string|null $accountancy_code
 * @property string|null $module
 * @property int $position
 *
 * @package App\Models
 */
class LlxCPaiement extends Model
{
	protected $table = 'llx_c_paiement';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'type' => 'int',
		'active' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'entity',
		'code',
		'libelle',
		'type',
		'active',
		'accountancy_code',
		'module',
		'position'
	];
}
