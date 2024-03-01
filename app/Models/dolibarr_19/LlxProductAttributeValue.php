<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductAttributeValue
 *
 * @property int $rowid
 * @property int $fk_product_attribute
 * @property string $ref
 * @property string $value
 * @property int $entity
 * @property int $position
 *
 * @package App\Models
 */
class LlxProductAttributeValue extends Model
{
	protected $table = 'llx_product_attribute_value';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_product_attribute' => 'int',
		'entity' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'fk_product_attribute',
		'ref',
		'value',
		'entity',
		'position'
	];
}
