<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductPriceByQty
 *
 * @property int $rowid
 * @property int $fk_product_price
 * @property float|null $price
 * @property string|null $price_base_type
 * @property float|null $quantity
 * @property float $remise_percent
 * @property float $remise
 * @property float|null $unitprice
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_tx
 * @property float|null $multicurrency_price
 * @property float|null $multicurrency_price_ttc
 * @property Carbon|null $tms
 * @property string|null $import_key
 *
 * @property LlxProductPrice $llx_product_price
 *
 * @package App\Models
 */
class LlxProductPriceByQty extends Model
{
	protected $table = 'llx_product_price_by_qty';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_product_price' => 'int',
		'price' => 'float',
		'quantity' => 'float',
		'remise_percent' => 'float',
		'remise' => 'float',
		'unitprice' => 'float',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_multicurrency' => 'int',
		'multicurrency_tx' => 'float',
		'multicurrency_price' => 'float',
		'multicurrency_price_ttc' => 'float',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'fk_product_price',
		'price',
		'price_base_type',
		'quantity',
		'remise_percent',
		'remise',
		'unitprice',
		'fk_user_creat',
		'fk_user_modif',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_tx',
		'multicurrency_price',
		'multicurrency_price_ttc',
		'tms',
		'import_key'
	];

	public function llx_product_price()
	{
		return $this->belongsTo(LlxProductPrice::class, 'fk_product_price');
	}
}
