<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPaymentVariou
 *
 * @property int $rowid
 * @property string|null $ref
 * @property string|null $num_payment
 * @property string|null $label
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property Carbon|null $datep
 * @property Carbon|null $datev
 * @property int $sens
 * @property float $amount
 * @property int $fk_typepayment
 * @property string|null $accountancy_code
 * @property string|null $subledger_account
 * @property int|null $fk_projet
 * @property int $entity
 * @property string|null $note
 * @property int|null $fk_bank
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 *
 * @package App\Models
 */
class LlxPaymentVariou extends Model
{
	protected $table = 'llx_payment_various';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'datec' => 'datetime',
		'datep' => 'datetime',
		'datev' => 'datetime',
		'sens' => 'int',
		'amount' => 'float',
		'fk_typepayment' => 'int',
		'fk_projet' => 'int',
		'entity' => 'int',
		'fk_bank' => 'int',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'ref',
		'num_payment',
		'label',
		'tms',
		'datec',
		'datep',
		'datev',
		'sens',
		'amount',
		'fk_typepayment',
		'accountancy_code',
		'subledger_account',
		'fk_projet',
		'entity',
		'note',
		'fk_bank',
		'fk_user_author',
		'fk_user_modif'
	];
}
