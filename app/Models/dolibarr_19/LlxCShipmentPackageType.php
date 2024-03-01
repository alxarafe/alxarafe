<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCShipmentPackageType
 *
 * @property int $rowid
 * @property string $label
 * @property string|null $description
 * @property int $active
 * @property int $entity
 *
 * @package App\Models
 */
class LlxCShipmentPackageType extends Model
{
	protected $table = 'llx_c_shipment_package_type';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'active' => 'int',
		'entity' => 'int'
	];

	protected $fillable = [
		'label',
		'description',
		'active',
		'entity'
	];
}
