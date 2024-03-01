<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSocieteRemiseExcept
 *
 * @property int $rowid
 * @property int $entity
 * @property int $fk_soc
 * @property int $discount_type
 * @property Carbon|null $datec
 * @property float $amount_ht
 * @property float $amount_tva
 * @property float $amount_ttc
 * @property float $tva_tx
 * @property string|null $vat_src_code
 * @property int $fk_user
 * @property int|null $fk_facture_line
 * @property int|null $fk_facture
 * @property int|null $fk_facture_source
 * @property int|null $fk_invoice_supplier_line
 * @property int|null $fk_invoice_supplier
 * @property int|null $fk_invoice_supplier_source
 * @property string $description
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_tx
 * @property float $multicurrency_amount_ht
 * @property float $multicurrency_amount_tva
 * @property float $multicurrency_amount_ttc
 *
 * @property LlxFacturedet|null $llx_facturedet
 * @property LlxFactureFournDet|null $llx_facture_fourn_det
 * @property LlxSociete $llx_societe
 * @property LlxFacture|null $llx_facture
 * @property LlxFactureFourn|null $llx_facture_fourn
 * @property LlxUser $llx_user
 *
 * @package App\Models
 */
class LlxSocieteRemiseExcept extends Model
{
	protected $table = 'llx_societe_remise_except';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_soc' => 'int',
		'discount_type' => 'int',
		'datec' => 'datetime',
		'amount_ht' => 'float',
		'amount_tva' => 'float',
		'amount_ttc' => 'float',
		'tva_tx' => 'float',
		'fk_user' => 'int',
		'fk_facture_line' => 'int',
		'fk_facture' => 'int',
		'fk_facture_source' => 'int',
		'fk_invoice_supplier_line' => 'int',
		'fk_invoice_supplier' => 'int',
		'fk_invoice_supplier_source' => 'int',
		'multicurrency_tx' => 'float',
		'multicurrency_amount_ht' => 'float',
		'multicurrency_amount_tva' => 'float',
		'multicurrency_amount_ttc' => 'float'
	];

	protected $fillable = [
		'entity',
		'fk_soc',
		'discount_type',
		'datec',
		'amount_ht',
		'amount_tva',
		'amount_ttc',
		'tva_tx',
		'vat_src_code',
		'fk_user',
		'fk_facture_line',
		'fk_facture',
		'fk_facture_source',
		'fk_invoice_supplier_line',
		'fk_invoice_supplier',
		'fk_invoice_supplier_source',
		'description',
		'multicurrency_code',
		'multicurrency_tx',
		'multicurrency_amount_ht',
		'multicurrency_amount_tva',
		'multicurrency_amount_ttc'
	];

	public function llx_facturedet()
	{
		return $this->belongsTo(LlxFacturedet::class, 'fk_facture_line');
	}

	public function llx_facture_fourn_det()
	{
		return $this->belongsTo(LlxFactureFournDet::class, 'fk_invoice_supplier_line');
	}

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}

	public function llx_facture()
	{
		return $this->belongsTo(LlxFacture::class, 'fk_facture_source');
	}

	public function llx_facture_fourn()
	{
		return $this->belongsTo(LlxFactureFourn::class, 'fk_invoice_supplier');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user');
	}
}
