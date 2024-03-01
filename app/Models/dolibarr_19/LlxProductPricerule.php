<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductPricerule
 *
 * @property int $rowid
 * @property int $level
 * @property int $fk_level
 * @property float $var_percent
 * @property float $var_min_percent
 *
 * @package App\Models
 */
class LlxProductPricerule extends Model
{
	protected $table = 'llx_product_pricerules';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'level' => 'int',
		'fk_level' => 'int',
		'var_percent' => 'float',
		'var_min_percent' => 'float'
	];

	protected $fillable = [
		'level',
		'fk_level',
		'var_percent',
		'var_min_percent'
	];
}
