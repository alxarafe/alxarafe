<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCChargesociale
 *
 * @property int $id
 * @property string|null $libelle
 * @property int $deductible
 * @property int $active
 * @property string $code
 * @property string|null $accountancy_code
 * @property int $fk_pays
 * @property string|null $module
 *
 * @package App\Models
 */
class LlxCChargesociale extends Model
{
	protected $table = 'llx_c_chargesociales';
	public $timestamps = false;

	protected $casts = [
		'deductible' => 'int',
		'active' => 'int',
		'fk_pays' => 'int'
	];

	protected $fillable = [
		'libelle',
		'deductible',
		'active',
		'code',
		'accountancy_code',
		'fk_pays',
		'module'
	];
}
