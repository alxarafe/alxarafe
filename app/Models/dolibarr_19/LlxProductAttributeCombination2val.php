<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductAttributeCombination2val
 *
 * @property int $rowid
 * @property int $fk_prod_combination
 * @property int $fk_prod_attr
 * @property int $fk_prod_attr_val
 *
 * @package App\Models
 */
class LlxProductAttributeCombination2val extends Model
{
	protected $table = 'llx_product_attribute_combination2val';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_prod_combination' => 'int',
		'fk_prod_attr' => 'int',
		'fk_prod_attr_val' => 'int'
	];

	protected $fillable = [
		'fk_prod_combination',
		'fk_prod_attr',
		'fk_prod_attr_val'
	];
}
