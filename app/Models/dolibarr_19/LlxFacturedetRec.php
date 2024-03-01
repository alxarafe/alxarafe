<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFacturedetRec
 *
 * @property int $rowid
 * @property int $fk_facture
 * @property int|null $fk_parent_line
 * @property int|null $fk_product
 * @property int|null $product_type
 * @property string|null $label
 * @property string|null $description
 * @property string|null $vat_src_code
 * @property float|null $tva_tx
 * @property float|null $localtax1_tx
 * @property string|null $localtax1_type
 * @property float|null $localtax2_tx
 * @property string|null $localtax2_type
 * @property float|null $qty
 * @property float|null $remise_percent
 * @property float|null $remise
 * @property float|null $subprice
 * @property float|null $price
 * @property float|null $total_ht
 * @property float|null $total_tva
 * @property float|null $total_localtax1
 * @property float|null $total_localtax2
 * @property float|null $total_ttc
 * @property int|null $date_start_fill
 * @property int|null $date_end_fill
 * @property int|null $info_bits
 * @property float|null $buy_price_ht
 * @property int|null $fk_product_fournisseur_price
 * @property int|null $special_code
 * @property int|null $rang
 * @property int|null $fk_contract_line
 * @property int|null $fk_unit
 * @property string|null $import_key
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_subprice
 * @property float|null $multicurrency_total_ht
 * @property float|null $multicurrency_total_tva
 * @property float|null $multicurrency_total_ttc
 *
 * @property LlxCUnit|null $llx_c_unit
 *
 * @package App\Models
 */
class LlxFacturedetRec extends Model
{
	protected $table = 'llx_facturedet_rec';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_facture' => 'int',
		'fk_parent_line' => 'int',
		'fk_product' => 'int',
		'product_type' => 'int',
		'tva_tx' => 'float',
		'localtax1_tx' => 'float',
		'localtax2_tx' => 'float',
		'qty' => 'float',
		'remise_percent' => 'float',
		'remise' => 'float',
		'subprice' => 'float',
		'price' => 'float',
		'total_ht' => 'float',
		'total_tva' => 'float',
		'total_localtax1' => 'float',
		'total_localtax2' => 'float',
		'total_ttc' => 'float',
		'date_start_fill' => 'int',
		'date_end_fill' => 'int',
		'info_bits' => 'int',
		'buy_price_ht' => 'float',
		'fk_product_fournisseur_price' => 'int',
		'special_code' => 'int',
		'rang' => 'int',
		'fk_contract_line' => 'int',
		'fk_unit' => 'int',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_multicurrency' => 'int',
		'multicurrency_subprice' => 'float',
		'multicurrency_total_ht' => 'float',
		'multicurrency_total_tva' => 'float',
		'multicurrency_total_ttc' => 'float'
	];

	protected $fillable = [
		'fk_facture',
		'fk_parent_line',
		'fk_product',
		'product_type',
		'label',
		'description',
		'vat_src_code',
		'tva_tx',
		'localtax1_tx',
		'localtax1_type',
		'localtax2_tx',
		'localtax2_type',
		'qty',
		'remise_percent',
		'remise',
		'subprice',
		'price',
		'total_ht',
		'total_tva',
		'total_localtax1',
		'total_localtax2',
		'total_ttc',
		'date_start_fill',
		'date_end_fill',
		'info_bits',
		'buy_price_ht',
		'fk_product_fournisseur_price',
		'special_code',
		'rang',
		'fk_contract_line',
		'fk_unit',
		'import_key',
		'fk_user_author',
		'fk_user_modif',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_subprice',
		'multicurrency_total_ht',
		'multicurrency_total_tva',
		'multicurrency_total_ttc'
	];

	public function llx_c_unit()
	{
		return $this->belongsTo(LlxCUnit::class, 'fk_unit');
	}
}
