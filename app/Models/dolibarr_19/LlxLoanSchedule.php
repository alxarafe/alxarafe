<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxLoanSchedule
 *
 * @property int $rowid
 * @property int|null $fk_loan
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property Carbon|null $datep
 * @property float|null $amount_capital
 * @property float|null $amount_insurance
 * @property float|null $amount_interest
 * @property int $fk_typepayment
 * @property string|null $num_payment
 * @property string|null $note_private
 * @property string|null $note_public
 * @property int $fk_bank
 * @property int|null $fk_payment_loan
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 *
 * @package App\Models
 */
class LlxLoanSchedule extends Model
{
	protected $table = 'llx_loan_schedule';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_loan' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'datep' => 'datetime',
		'amount_capital' => 'float',
		'amount_insurance' => 'float',
		'amount_interest' => 'float',
		'fk_typepayment' => 'int',
		'fk_bank' => 'int',
		'fk_payment_loan' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'fk_loan',
		'datec',
		'tms',
		'datep',
		'amount_capital',
		'amount_insurance',
		'amount_interest',
		'fk_typepayment',
		'num_payment',
		'note_private',
		'note_public',
		'fk_bank',
		'fk_payment_loan',
		'fk_user_creat',
		'fk_user_modif'
	];
}
