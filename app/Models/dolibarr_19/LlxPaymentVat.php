<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPaymentVat
 *
 * @property int $rowid
 * @property int|null $fk_tva
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property Carbon|null $datep
 * @property float|null $amount
 * @property int $fk_typepaiement
 * @property string|null $num_paiement
 * @property string|null $note
 * @property int $fk_bank
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 *
 * @package App\Models
 */
class LlxPaymentVat extends Model
{
	protected $table = 'llx_payment_vat';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_tva' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'datep' => 'datetime',
		'amount' => 'float',
		'fk_typepaiement' => 'int',
		'fk_bank' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'fk_tva',
		'datec',
		'tms',
		'datep',
		'amount',
		'fk_typepaiement',
		'num_paiement',
		'note',
		'fk_bank',
		'fk_user_creat',
		'fk_user_modif'
	];
}
