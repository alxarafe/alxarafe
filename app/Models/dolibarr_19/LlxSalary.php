<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSalary
 *
 * @property int $rowid
 * @property string|null $ref
 * @property string|null $ref_ext
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property int $fk_user
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
 * @property string|null $note_public
 * @property int|null $fk_bank
 * @property int $paye
 * @property int|null $fk_account
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 *
 * @package App\Models
 */
class LlxSalary extends Model
{
	protected $table = 'llx_salary';
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
		'paye' => 'int',
		'fk_account' => 'int',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'ref',
		'ref_ext',
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
		'note_public',
		'fk_bank',
		'paye',
		'fk_account',
		'fk_user_author',
		'fk_user_modif'
	];
}
