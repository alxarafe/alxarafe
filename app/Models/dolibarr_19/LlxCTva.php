<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCTva
 *
 * @property int $rowid
 * @property int $entity
 * @property int $fk_pays
 * @property string|null $code
 * @property float $taux
 * @property string $localtax1
 * @property string $localtax1_type
 * @property string $localtax2
 * @property string $localtax2_type
 * @property int|null $use_default
 * @property int $recuperableonly
 * @property string|null $note
 * @property int $active
 * @property string|null $accountancy_code_sell
 * @property string|null $accountancy_code_buy
 *
 * @package App\Models
 */
class LlxCTva extends Model
{
	protected $table = 'llx_c_tva';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_pays' => 'int',
		'taux' => 'float',
		'use_default' => 'int',
		'recuperableonly' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'entity',
		'fk_pays',
		'code',
		'taux',
		'localtax1',
		'localtax1_type',
		'localtax2',
		'localtax2_type',
		'use_default',
		'recuperableonly',
		'note',
		'active',
		'accountancy_code_sell',
		'accountancy_code_buy'
	];
}
