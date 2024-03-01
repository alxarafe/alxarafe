<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductAttributeCombinationPriceLevel
 *
 * @property int $rowid
 * @property int $fk_product_attribute_combination
 * @property int $fk_price_level
 * @property float $variation_price
 * @property int|null $variation_price_percentage
 *
 * @package App\Models
 */
class LlxProductAttributeCombinationPriceLevel extends Model
{
	protected $table = 'llx_product_attribute_combination_price_level';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_product_attribute_combination' => 'int',
		'fk_price_level' => 'int',
		'variation_price' => 'float',
		'variation_price_percentage' => 'int'
	];

	protected $fillable = [
		'fk_product_attribute_combination',
		'fk_price_level',
		'variation_price',
		'variation_price_percentage'
	];
}
