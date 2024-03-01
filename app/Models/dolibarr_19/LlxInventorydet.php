<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxInventorydet
 *
 * @property int $rowid
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int|null $fk_inventory
 * @property int|null $fk_warehouse
 * @property int|null $fk_product
 * @property string|null $batch
 * @property float|null $qty_stock
 * @property float|null $qty_view
 * @property float|null $qty_regulated
 * @property float|null $pmp_real
 * @property float|null $pmp_expected
 * @property int|null $fk_movement
 *
 * @package App\Models
 */
class LlxInventorydet extends Model
{
	protected $table = 'llx_inventorydet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_inventory' => 'int',
		'fk_warehouse' => 'int',
		'fk_product' => 'int',
		'qty_stock' => 'float',
		'qty_view' => 'float',
		'qty_regulated' => 'float',
		'pmp_real' => 'float',
		'pmp_expected' => 'float',
		'fk_movement' => 'int'
	];

	protected $fillable = [
		'datec',
		'tms',
		'fk_inventory',
		'fk_warehouse',
		'fk_product',
		'batch',
		'qty_stock',
		'qty_view',
		'qty_regulated',
		'pmp_real',
		'pmp_expected',
		'fk_movement'
	];
}
