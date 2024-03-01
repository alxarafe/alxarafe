<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFactureFournDet
 *
 * @property int $rowid
 * @property int $fk_facture_fourn
 * @property int|null $fk_parent_line
 * @property int|null $fk_product
 * @property string|null $ref
 * @property string|null $label
 * @property string|null $description
 * @property float|null $pu_ht
 * @property float|null $pu_ttc
 * @property float|null $qty
 * @property float|null $remise_percent
 * @property int|null $fk_remise_except
 * @property string|null $vat_src_code
 * @property float|null $tva_tx
 * @property float|null $localtax1_tx
 * @property string|null $localtax1_type
 * @property float|null $localtax2_tx
 * @property string|null $localtax2_type
 * @property float|null $total_ht
 * @property float|null $tva
 * @property float|null $total_localtax1
 * @property float|null $total_localtax2
 * @property float|null $total_ttc
 * @property int|null $product_type
 * @property Carbon|null $date_start
 * @property Carbon|null $date_end
 * @property int|null $info_bits
 * @property int $fk_code_ventilation
 * @property int|null $special_code
 * @property int|null $rang
 * @property string|null $import_key
 * @property int|null $fk_unit
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_subprice
 * @property float|null $multicurrency_total_ht
 * @property float|null $multicurrency_total_tva
 * @property float|null $multicurrency_total_ttc
 *
 * @property LlxFactureFourn $llx_facture_fourn
 * @property LlxCUnit|null $llx_c_unit
 * @property Collection|LlxSocieteRemiseExcept[] $llx_societe_remise_excepts
 *
 * @package App\Models
 */
class LlxFactureFournDet extends Model
{
	protected $table = 'llx_facture_fourn_det';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_facture_fourn' => 'int',
		'fk_parent_line' => 'int',
		'fk_product' => 'int',
		'pu_ht' => 'float',
		'pu_ttc' => 'float',
		'qty' => 'float',
		'remise_percent' => 'float',
		'fk_remise_except' => 'int',
		'tva_tx' => 'float',
		'localtax1_tx' => 'float',
		'localtax2_tx' => 'float',
		'total_ht' => 'float',
		'tva' => 'float',
		'total_localtax1' => 'float',
		'total_localtax2' => 'float',
		'total_ttc' => 'float',
		'product_type' => 'int',
		'date_start' => 'datetime',
		'date_end' => 'datetime',
		'info_bits' => 'int',
		'fk_code_ventilation' => 'int',
		'special_code' => 'int',
		'rang' => 'int',
		'fk_unit' => 'int',
		'fk_multicurrency' => 'int',
		'multicurrency_subprice' => 'float',
		'multicurrency_total_ht' => 'float',
		'multicurrency_total_tva' => 'float',
		'multicurrency_total_ttc' => 'float'
	];

	protected $fillable = [
		'fk_facture_fourn',
		'fk_parent_line',
		'fk_product',
		'ref',
		'label',
		'description',
		'pu_ht',
		'pu_ttc',
		'qty',
		'remise_percent',
		'fk_remise_except',
		'vat_src_code',
		'tva_tx',
		'localtax1_tx',
		'localtax1_type',
		'localtax2_tx',
		'localtax2_type',
		'total_ht',
		'tva',
		'total_localtax1',
		'total_localtax2',
		'total_ttc',
		'product_type',
		'date_start',
		'date_end',
		'info_bits',
		'fk_code_ventilation',
		'special_code',
		'rang',
		'import_key',
		'fk_unit',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_subprice',
		'multicurrency_total_ht',
		'multicurrency_total_tva',
		'multicurrency_total_ttc'
	];

	public function llx_facture_fourn()
	{
		return $this->belongsTo(LlxFactureFourn::class, 'fk_facture_fourn');
	}

	public function llx_c_unit()
	{
		return $this->belongsTo(LlxCUnit::class, 'fk_unit');
	}

	public function llx_societe_remise_excepts()
	{
		return $this->hasMany(LlxSocieteRemiseExcept::class, 'fk_invoice_supplier_line');
	}
}
