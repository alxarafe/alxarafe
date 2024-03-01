<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPaymentExpensereport
 *
 * @property int $rowid
 * @property int|null $fk_expensereport
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property Carbon|null $datep
 * @property float|null $amount
 * @property int $fk_typepayment
 * @property string|null $num_payment
 * @property string|null $note
 * @property int $fk_bank
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 *
 * @package App\Models
 */
class LlxPaymentExpensereport extends Model
{
	protected $table = 'llx_payment_expensereport';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_expensereport' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'datep' => 'datetime',
		'amount' => 'float',
		'fk_typepayment' => 'int',
		'fk_bank' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'fk_expensereport',
		'datec',
		'tms',
		'datep',
		'amount',
		'fk_typepayment',
		'num_payment',
		'note',
		'fk_bank',
		'fk_user_creat',
		'fk_user_modif'
	];
}
