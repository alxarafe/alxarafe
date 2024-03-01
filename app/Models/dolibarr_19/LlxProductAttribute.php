<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductAttribute
 *
 * @property int $rowid
 * @property string $ref
 * @property string|null $ref_ext
 * @property string $label
 * @property int $position
 * @property int $entity
 *
 * @package App\Models
 */
class LlxProductAttribute extends Model
{
	protected $table = 'llx_product_attribute';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'position' => 'int',
		'entity' => 'int'
	];

	protected $fillable = [
		'ref',
		'ref_ext',
		'label',
		'position',
		'entity'
	];
}
