<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductCustomerPriceLog
 *
 * @property int $rowid
 * @property int $entity
 * @property Carbon|null $datec
 * @property int $fk_product
 * @property int $fk_soc
 * @property string|null $ref_customer
 * @property float|null $price
 * @property float|null $price_ttc
 * @property float|null $price_min
 * @property float|null $price_min_ttc
 * @property string|null $price_base_type
 * @property string|null $default_vat_code
 * @property float|null $tva_tx
 * @property int $recuperableonly
 * @property float|null $localtax1_tx
 * @property string $localtax1_type
 * @property float|null $localtax2_tx
 * @property string $localtax2_type
 * @property int|null $fk_user
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxProductCustomerPriceLog extends Model
{
	protected $table = 'llx_product_customer_price_log';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'datec' => 'datetime',
		'fk_product' => 'int',
		'fk_soc' => 'int',
		'price' => 'float',
		'price_ttc' => 'float',
		'price_min' => 'float',
		'price_min_ttc' => 'float',
		'tva_tx' => 'float',
		'recuperableonly' => 'int',
		'localtax1_tx' => 'float',
		'localtax2_tx' => 'float',
		'fk_user' => 'int'
	];

	protected $fillable = [
		'entity',
		'datec',
		'fk_product',
		'fk_soc',
		'ref_customer',
		'price',
		'price_ttc',
		'price_min',
		'price_min_ttc',
		'price_base_type',
		'default_vat_code',
		'tva_tx',
		'recuperableonly',
		'localtax1_tx',
		'localtax1_type',
		'localtax2_tx',
		'localtax2_type',
		'fk_user',
		'import_key'
	];
}
