<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCExpTaxRange
 *
 * @property int $rowid
 * @property int $fk_c_exp_tax_cat
 * @property float $range_ik
 * @property int $entity
 * @property int $active
 *
 * @package App\Models
 */
class LlxCExpTaxRange extends Model
{
	protected $table = 'llx_c_exp_tax_range';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_c_exp_tax_cat' => 'int',
		'range_ik' => 'float',
		'entity' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'fk_c_exp_tax_cat',
		'range_ik',
		'entity',
		'active'
	];
}
