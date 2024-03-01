<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxLocaltax
 *
 * @property int $rowid
 * @property int $entity
 * @property int|null $localtaxtype
 * @property Carbon|null $tms
 * @property Carbon|null $datep
 * @property Carbon|null $datev
 * @property float|null $amount
 * @property string|null $label
 * @property string|null $note
 * @property int|null $fk_bank
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 *
 * @package App\Models
 */
class LlxLocaltax extends Model
{
	protected $table = 'llx_localtax';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'localtaxtype' => 'int',
		'tms' => 'datetime',
		'datep' => 'datetime',
		'datev' => 'datetime',
		'amount' => 'float',
		'fk_bank' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'entity',
		'localtaxtype',
		'tms',
		'datep',
		'datev',
		'amount',
		'label',
		'note',
		'fk_bank',
		'fk_user_creat',
		'fk_user_modif'
	];
}
