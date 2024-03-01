<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSupplierProposaldet
 *
 * @property int $rowid
 * @property int $fk_supplier_proposal
 * @property int|null $fk_parent_line
 * @property int|null $fk_product
 * @property string|null $label
 * @property string|null $description
 * @property int|null $fk_remise_except
 * @property string|null $vat_src_code
 * @property float|null $tva_tx
 * @property float|null $localtax1_tx
 * @property string|null $localtax1_type
 * @property float|null $localtax2_tx
 * @property string|null $localtax2_type
 * @property float|null $qty
 * @property float|null $remise_percent
 * @property float|null $remise
 * @property float|null $price
 * @property float|null $subprice
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
 * @property int|null $special_code
 * @property int|null $rang
 * @property string|null $ref_fourn
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_subprice
 * @property float|null $multicurrency_total_ht
 * @property float|null $multicurrency_total_tva
 * @property float|null $multicurrency_total_ttc
 * @property int|null $fk_unit
 *
 * @property LlxSupplierProposal $llx_supplier_proposal
 * @property LlxCUnit|null $llx_c_unit
 *
 * @package App\Models
 */
class LlxSupplierProposaldet extends Model
{
	protected $table = 'llx_supplier_proposaldet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_supplier_proposal' => 'int',
		'fk_parent_line' => 'int',
		'fk_product' => 'int',
		'fk_remise_except' => 'int',
		'tva_tx' => 'float',
		'localtax1_tx' => 'float',
		'localtax2_tx' => 'float',
		'qty' => 'float',
		'remise_percent' => 'float',
		'remise' => 'float',
		'price' => 'float',
		'subprice' => 'float',
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
		'special_code' => 'int',
		'rang' => 'int',
		'fk_multicurrency' => 'int',
		'multicurrency_subprice' => 'float',
		'multicurrency_total_ht' => 'float',
		'multicurrency_total_tva' => 'float',
		'multicurrency_total_ttc' => 'float',
		'fk_unit' => 'int'
	];

	protected $fillable = [
		'fk_supplier_proposal',
		'fk_parent_line',
		'fk_product',
		'label',
		'description',
		'fk_remise_except',
		'vat_src_code',
		'tva_tx',
		'localtax1_tx',
		'localtax1_type',
		'localtax2_tx',
		'localtax2_type',
		'qty',
		'remise_percent',
		'remise',
		'price',
		'subprice',
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
		'special_code',
		'rang',
		'ref_fourn',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_subprice',
		'multicurrency_total_ht',
		'multicurrency_total_tva',
		'multicurrency_total_ttc',
		'fk_unit'
	];

	public function llx_supplier_proposal()
	{
		return $this->belongsTo(LlxSupplierProposal::class, 'fk_supplier_proposal');
	}

	public function llx_c_unit()
	{
		return $this->belongsTo(LlxCUnit::class, 'fk_unit');
	}
}
