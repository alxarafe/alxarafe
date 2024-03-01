<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxMrpProduction
 *
 * @property int $rowid
 * @property int $fk_mo
 * @property int|null $origin_id
 * @property string|null $origin_type
 * @property int $position
 * @property int $fk_product
 * @property int|null $fk_warehouse
 * @property float $qty
 * @property int|null $qty_frozen
 * @property int|null $disable_stock_change
 * @property string|null $batch
 * @property string|null $role
 * @property int|null $fk_mrp_production
 * @property int|null $fk_stock_movement
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $import_key
 * @property int|null $fk_default_workstation
 * @property int|null $fk_unit
 *
 * @property LlxMrpMo $llx_mrp_mo
 * @property LlxProduct $llx_product
 * @property LlxStockMouvement|null $llx_stock_mouvement
 *
 * @package App\Models
 */
class LlxMrpProduction extends Model
{
	protected $table = 'llx_mrp_production';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_mo' => 'int',
		'origin_id' => 'int',
		'position' => 'int',
		'fk_product' => 'int',
		'fk_warehouse' => 'int',
		'qty' => 'float',
		'qty_frozen' => 'int',
		'disable_stock_change' => 'int',
		'fk_mrp_production' => 'int',
		'fk_stock_movement' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_default_workstation' => 'int',
		'fk_unit' => 'int'
	];

	protected $fillable = [
		'fk_mo',
		'origin_id',
		'origin_type',
		'position',
		'fk_product',
		'fk_warehouse',
		'qty',
		'qty_frozen',
		'disable_stock_change',
		'batch',
		'role',
		'fk_mrp_production',
		'fk_stock_movement',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'import_key',
		'fk_default_workstation',
		'fk_unit'
	];

	public function llx_mrp_mo()
	{
		return $this->belongsTo(LlxMrpMo::class, 'fk_mo');
	}

	public function llx_product()
	{
		return $this->belongsTo(LlxProduct::class, 'fk_product');
	}

	public function llx_stock_mouvement()
	{
		return $this->belongsTo(LlxStockMouvement::class, 'fk_stock_movement');
	}
}
