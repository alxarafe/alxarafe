<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductAttributeCombination
 *
 * @property int $rowid
 * @property int $fk_product_parent
 * @property int $fk_product_child
 * @property float $variation_price
 * @property int|null $variation_price_percentage
 * @property float $variation_weight
 * @property string|null $variation_ref_ext
 * @property int $entity
 *
 * @package App\Models
 */
class LlxProductAttributeCombination extends Model
{
	protected $table = 'llx_product_attribute_combination';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_product_parent' => 'int',
		'fk_product_child' => 'int',
		'variation_price' => 'float',
		'variation_price_percentage' => 'int',
		'variation_weight' => 'float',
		'entity' => 'int'
	];

	protected $fillable = [
		'fk_product_parent',
		'fk_product_child',
		'variation_price',
		'variation_price_percentage',
		'variation_weight',
		'variation_ref_ext',
		'entity'
	];
}
