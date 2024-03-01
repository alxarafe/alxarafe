<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxExpensereportIk
 *
 * @property int $rowid
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int $fk_c_exp_tax_cat
 * @property int $fk_range
 * @property float $coef
 * @property float $ikoffset
 * @property int|null $active
 *
 * @package App\Models
 */
class LlxExpensereportIk extends Model
{
	protected $table = 'llx_expensereport_ik';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_c_exp_tax_cat' => 'int',
		'fk_range' => 'int',
		'coef' => 'float',
		'ikoffset' => 'float',
		'active' => 'int'
	];

	protected $fillable = [
		'datec',
		'tms',
		'fk_c_exp_tax_cat',
		'fk_range',
		'coef',
		'ikoffset',
		'active'
	];
}
