<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFichinterdetRec
 *
 * @property int $rowid
 * @property int $fk_fichinter
 * @property Carbon|null $date
 * @property string|null $description
 * @property int|null $duree
 * @property int|null $rang
 * @property float|null $total_ht
 * @property float|null $subprice
 * @property int|null $fk_parent_line
 * @property int|null $fk_product
 * @property string|null $label
 * @property float|null $tva_tx
 * @property float|null $localtax1_tx
 * @property string|null $localtax1_type
 * @property float|null $localtax2_tx
 * @property string|null $localtax2_type
 * @property float|null $qty
 * @property float|null $remise_percent
 * @property int|null $fk_remise_except
 * @property float|null $price
 * @property float|null $total_tva
 * @property float|null $total_localtax1
 * @property float|null $total_localtax2
 * @property float|null $total_ttc
 * @property int|null $product_type
 * @property Carbon|null $date_start
 * @property Carbon|null $date_end
 * @property int|null $info_bits
 * @property float|null $buy_price_ht
 * @property int|null $fk_product_fournisseur_price
 * @property int $fk_code_ventilation
 * @property int|null $special_code
 * @property int|null $fk_unit
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxFichinterdetRec extends Model
{
	protected $table = 'llx_fichinterdet_rec';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_fichinter' => 'int',
		'date' => 'datetime',
		'duree' => 'int',
		'rang' => 'int',
		'total_ht' => 'float',
		'subprice' => 'float',
		'fk_parent_line' => 'int',
		'fk_product' => 'int',
		'tva_tx' => 'float',
		'localtax1_tx' => 'float',
		'localtax2_tx' => 'float',
		'qty' => 'float',
		'remise_percent' => 'float',
		'fk_remise_except' => 'int',
		'price' => 'float',
		'total_tva' => 'float',
		'total_localtax1' => 'float',
		'total_localtax2' => 'float',
		'total_ttc' => 'float',
		'product_type' => 'int',
		'date_start' => 'datetime',
		'date_end' => 'datetime',
		'info_bits' => 'int',
		'buy_price_ht' => 'float',
		'fk_product_fournisseur_price' => 'int',
		'fk_code_ventilation' => 'int',
		'special_code' => 'int',
		'fk_unit' => 'int'
	];

	protected $fillable = [
		'fk_fichinter',
		'date',
		'description',
		'duree',
		'rang',
		'total_ht',
		'subprice',
		'fk_parent_line',
		'fk_product',
		'label',
		'tva_tx',
		'localtax1_tx',
		'localtax1_type',
		'localtax2_tx',
		'localtax2_type',
		'qty',
		'remise_percent',
		'fk_remise_except',
		'price',
		'total_tva',
		'total_localtax1',
		'total_localtax2',
		'total_ttc',
		'product_type',
		'date_start',
		'date_end',
		'info_bits',
		'buy_price_ht',
		'fk_product_fournisseur_price',
		'fk_code_ventilation',
		'special_code',
		'fk_unit',
		'import_key'
	];
}
