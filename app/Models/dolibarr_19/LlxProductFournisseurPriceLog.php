<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductFournisseurPriceLog
 *
 * @property int $rowid
 * @property Carbon|null $datec
 * @property int $fk_product_fournisseur
 * @property float|null $price
 * @property float|null $quantity
 * @property int|null $fk_user
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_tx
 * @property float|null $multicurrency_unitprice
 * @property float|null $multicurrency_price
 *
 * @package App\Models
 */
class LlxProductFournisseurPriceLog extends Model
{
	protected $table = 'llx_product_fournisseur_price_log';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datec' => 'datetime',
		'fk_product_fournisseur' => 'int',
		'price' => 'float',
		'quantity' => 'float',
		'fk_user' => 'int',
		'fk_multicurrency' => 'int',
		'multicurrency_tx' => 'float',
		'multicurrency_unitprice' => 'float',
		'multicurrency_price' => 'float'
	];

	protected $fillable = [
		'datec',
		'fk_product_fournisseur',
		'price',
		'quantity',
		'fk_user',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_tx',
		'multicurrency_unitprice',
		'multicurrency_price'
	];
}
