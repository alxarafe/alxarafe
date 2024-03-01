<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxStocktransferStocktransferline
 *
 * @property int $rowid
 * @property float|null $amount
 * @property float|null $qty
 * @property int $fk_warehouse_source
 * @property int $fk_warehouse_destination
 * @property int $fk_stocktransfer
 * @property int $fk_product
 * @property string|null $batch
 * @property float|null $pmp
 * @property int|null $rang
 * @property int|null $fk_parent_line
 *
 * @package App\Models
 */
class LlxStocktransferStocktransferline extends Model
{
	protected $table = 'llx_stocktransfer_stocktransferline';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'amount' => 'float',
		'qty' => 'float',
		'fk_warehouse_source' => 'int',
		'fk_warehouse_destination' => 'int',
		'fk_stocktransfer' => 'int',
		'fk_product' => 'int',
		'pmp' => 'float',
		'rang' => 'int',
		'fk_parent_line' => 'int'
	];

	protected $fillable = [
		'amount',
		'qty',
		'fk_warehouse_source',
		'fk_warehouse_destination',
		'fk_stocktransfer',
		'fk_product',
		'batch',
		'pmp',
		'rang',
		'fk_parent_line'
	];
}
