<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxExpeditionPackage
 *
 * @property int $rowid
 * @property int $fk_expedition
 * @property string|null $description
 * @property float|null $value
 * @property int|null $fk_package_type
 * @property float|null $height
 * @property float|null $width
 * @property float|null $size
 * @property int|null $size_units
 * @property float|null $weight
 * @property int|null $weight_units
 * @property int|null $dangerous_goods
 * @property int|null $tail_lift
 * @property int|null $rang
 *
 * @package App\Models
 */
class LlxExpeditionPackage extends Model
{
	protected $table = 'llx_expedition_package';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_expedition' => 'int',
		'value' => 'float',
		'fk_package_type' => 'int',
		'height' => 'float',
		'width' => 'float',
		'size' => 'float',
		'size_units' => 'int',
		'weight' => 'float',
		'weight_units' => 'int',
		'dangerous_goods' => 'int',
		'tail_lift' => 'int',
		'rang' => 'int'
	];

	protected $fillable = [
		'fk_expedition',
		'description',
		'value',
		'fk_package_type',
		'height',
		'width',
		'size',
		'size_units',
		'weight',
		'weight_units',
		'dangerous_goods',
		'tail_lift',
		'rang'
	];
}
