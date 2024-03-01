<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductWarehouseProperty
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property int $fk_product
 * @property int $fk_entrepot
 * @property float|null $seuil_stock_alerte
 * @property float|null $desiredstock
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxProductWarehouseProperty extends Model
{
	protected $table = 'llx_product_warehouse_properties';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'fk_product' => 'int',
		'fk_entrepot' => 'int',
		'seuil_stock_alerte' => 'float',
		'desiredstock' => 'float'
	];

	protected $fillable = [
		'tms',
		'fk_product',
		'fk_entrepot',
		'seuil_stock_alerte',
		'desiredstock',
		'import_key'
	];
}
