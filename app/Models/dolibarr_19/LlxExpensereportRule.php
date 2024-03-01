<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxExpensereportRule
 *
 * @property int $rowid
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property Carbon $dates
 * @property Carbon $datee
 * @property float $amount
 * @property int $restrictive
 * @property int|null $fk_user
 * @property int|null $fk_usergroup
 * @property int $fk_c_type_fees
 * @property string $code_expense_rules_type
 * @property int|null $is_for_all
 * @property int|null $entity
 *
 * @package App\Models
 */
class LlxExpensereportRule extends Model
{
	protected $table = 'llx_expensereport_rules';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datec' => 'datetime',
		'tms' => 'datetime',
		'dates' => 'datetime',
		'datee' => 'datetime',
		'amount' => 'float',
		'restrictive' => 'int',
		'fk_user' => 'int',
		'fk_usergroup' => 'int',
		'fk_c_type_fees' => 'int',
		'is_for_all' => 'int',
		'entity' => 'int'
	];

	protected $fillable = [
		'datec',
		'tms',
		'dates',
		'datee',
		'amount',
		'restrictive',
		'fk_user',
		'fk_usergroup',
		'fk_c_type_fees',
		'code_expense_rules_type',
		'is_for_all',
		'entity'
	];
}
