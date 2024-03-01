<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPaymentSalary
 *
 * @property int $rowid
 * @property string|null $ref
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property int|null $fk_user
 * @property Carbon|null $datep
 * @property Carbon|null $datev
 * @property float|null $salary
 * @property float $amount
 * @property int|null $fk_projet
 * @property int $fk_typepayment
 * @property string|null $num_payment
 * @property string|null $label
 * @property Carbon|null $datesp
 * @property Carbon|null $dateep
 * @property int $entity
 * @property string|null $note
 * @property int|null $fk_bank
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_salary
 *
 * @property LlxUser|null $llx_user
 *
 * @package App\Models
 */
class LlxPaymentSalary extends Model
{
	protected $table = 'llx_payment_salary';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'datec' => 'datetime',
		'fk_user' => 'int',
		'datep' => 'datetime',
		'datev' => 'datetime',
		'salary' => 'float',
		'amount' => 'float',
		'fk_projet' => 'int',
		'fk_typepayment' => 'int',
		'datesp' => 'datetime',
		'dateep' => 'datetime',
		'entity' => 'int',
		'fk_bank' => 'int',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_salary' => 'int'
	];

	protected $fillable = [
		'ref',
		'tms',
		'datec',
		'fk_user',
		'datep',
		'datev',
		'salary',
		'amount',
		'fk_projet',
		'fk_typepayment',
		'num_payment',
		'label',
		'datesp',
		'dateep',
		'entity',
		'note',
		'fk_bank',
		'fk_user_author',
		'fk_user_modif',
		'fk_salary'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user');
	}
}
