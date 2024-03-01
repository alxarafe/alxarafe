<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFacturedet
 *
 * @property int $rowid
 * @property int $fk_facture
 * @property int|null $fk_parent_line
 * @property int|null $fk_product
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
 * @property int|null $fk_remise_except
 * @property float|null $subprice
 * @property float|null $price
 * @property float|null $total_ht
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
 * @property string|null $batch
 * @property int|null $fk_warehouse
 * @property int|null $special_code
 * @property int|null $rang
 * @property int|null $fk_contract_line
 * @property int|null $fk_unit
 * @property string|null $import_key
 * @property int $fk_code_ventilation
 * @property float|null $situation_percent
 * @property int|null $fk_prev_id
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_subprice
 * @property float|null $multicurrency_total_ht
 * @property float|null $multicurrency_total_tva
 * @property float|null $multicurrency_total_ttc
 * @property string|null $ref_ext
 *
 * @property LlxFacture $llx_facture
 * @property LlxCUnit|null $llx_c_unit
 * @property Collection|LlxSocieteRemiseExcept[] $llx_societe_remise_excepts
 *
 * @package App\Models
 */
class LlxFacturedet extends Model
{
	protected $table = 'llx_facturedet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_facture' => 'int',
		'fk_parent_line' => 'int',
		'fk_product' => 'int',
		'tva_tx' => 'float',
		'localtax1_tx' => 'float',
		'localtax2_tx' => 'float',
		'qty' => 'float',
		'remise_percent' => 'float',
		'remise' => 'float',
		'fk_remise_except' => 'int',
		'subprice' => 'float',
		'price' => 'float',
		'total_ht' => 'float',
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
		'fk_warehouse' => 'int',
		'special_code' => 'int',
		'rang' => 'int',
		'fk_contract_line' => 'int',
		'fk_unit' => 'int',
		'fk_code_ventilation' => 'int',
		'situation_percent' => 'float',
		'fk_prev_id' => 'int',
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
		'fk_remise_except',
		'subprice',
		'price',
		'total_ht',
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
		'batch',
		'fk_warehouse',
		'special_code',
		'rang',
		'fk_contract_line',
		'fk_unit',
		'import_key',
		'fk_code_ventilation',
		'situation_percent',
		'fk_prev_id',
		'fk_user_author',
		'fk_user_modif',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_subprice',
		'multicurrency_total_ht',
		'multicurrency_total_tva',
		'multicurrency_total_ttc',
		'ref_ext'
	];

	public function llx_facture()
	{
		return $this->belongsTo(LlxFacture::class, 'fk_facture');
	}

	public function llx_c_unit()
	{
		return $this->belongsTo(LlxCUnit::class, 'fk_unit');
	}

	public function llx_societe_remise_excepts()
	{
		return $this->hasMany(LlxSocieteRemiseExcept::class, 'fk_facture_line');
	}
}
