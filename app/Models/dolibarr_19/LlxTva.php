<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxTva
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property Carbon|null $datep
 * @property Carbon|null $datev
 * @property float $amount
 * @property int|null $fk_typepayment
 * @property string|null $num_payment
 * @property string|null $label
 * @property int $entity
 * @property string|null $note
 * @property int $paye
 * @property int|null $fk_account
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxTva extends Model
{
	protected $table = 'llx_tva';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'datec' => 'datetime',
		'datep' => 'datetime',
		'datev' => 'datetime',
		'amount' => 'float',
		'fk_typepayment' => 'int',
		'entity' => 'int',
		'paye' => 'int',
		'fk_account' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'tms',
		'datec',
		'datep',
		'datev',
		'amount',
		'fk_typepayment',
		'num_payment',
		'label',
		'entity',
		'note',
		'paye',
		'fk_account',
		'fk_user_creat',
		'fk_user_modif',
		'import_key'
	];
}
