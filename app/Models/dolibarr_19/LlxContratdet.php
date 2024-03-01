<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxContratdet
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property int $fk_contrat
 * @property int|null $fk_product
 * @property int|null $statut
 * @property string|null $label
 * @property string|null $description
 * @property int|null $fk_remise_except
 * @property Carbon|null $date_commande
 * @property Carbon|null $date_ouverture_prevue
 * @property Carbon|null $date_ouverture
 * @property Carbon|null $date_fin_validite
 * @property Carbon|null $date_cloture
 * @property string|null $vat_src_code
 * @property float|null $tva_tx
 * @property float|null $localtax1_tx
 * @property string|null $localtax1_type
 * @property float|null $localtax2_tx
 * @property string|null $localtax2_type
 * @property float $qty
 * @property float|null $remise_percent
 * @property float|null $subprice
 * @property float|null $price_ht
 * @property float|null $remise
 * @property float|null $total_ht
 * @property float|null $total_tva
 * @property float|null $total_localtax1
 * @property float|null $total_localtax2
 * @property float|null $total_ttc
 * @property int|null $product_type
 * @property int|null $info_bits
 * @property int|null $rang
 * @property float|null $buy_price_ht
 * @property int|null $fk_product_fournisseur_price
 * @property int $fk_user_author
 * @property int|null $fk_user_ouverture
 * @property int|null $fk_user_cloture
 * @property string|null $commentaire
 * @property int|null $fk_unit
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_subprice
 * @property float|null $multicurrency_total_ht
 * @property float|null $multicurrency_total_tva
 * @property float|null $multicurrency_total_ttc
 *
 * @property LlxContrat $llx_contrat
 * @property LlxProduct|null $llx_product
 * @property LlxCUnit|null $llx_c_unit
 * @property Collection|LlxContratdetLog[] $llx_contratdet_logs
 *
 * @package App\Models
 */
class LlxContratdet extends Model
{
	protected $table = 'llx_contratdet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'fk_contrat' => 'int',
		'fk_product' => 'int',
		'statut' => 'int',
		'fk_remise_except' => 'int',
		'date_commande' => 'datetime',
		'date_ouverture_prevue' => 'datetime',
		'date_ouverture' => 'datetime',
		'date_fin_validite' => 'datetime',
		'date_cloture' => 'datetime',
		'tva_tx' => 'float',
		'localtax1_tx' => 'float',
		'localtax2_tx' => 'float',
		'qty' => 'float',
		'remise_percent' => 'float',
		'subprice' => 'float',
		'price_ht' => 'float',
		'remise' => 'float',
		'total_ht' => 'float',
		'total_tva' => 'float',
		'total_localtax1' => 'float',
		'total_localtax2' => 'float',
		'total_ttc' => 'float',
		'product_type' => 'int',
		'info_bits' => 'int',
		'rang' => 'int',
		'buy_price_ht' => 'float',
		'fk_product_fournisseur_price' => 'int',
		'fk_user_author' => 'int',
		'fk_user_ouverture' => 'int',
		'fk_user_cloture' => 'int',
		'fk_unit' => 'int',
		'fk_multicurrency' => 'int',
		'multicurrency_subprice' => 'float',
		'multicurrency_total_ht' => 'float',
		'multicurrency_total_tva' => 'float',
		'multicurrency_total_ttc' => 'float'
	];

	protected $fillable = [
		'tms',
		'fk_contrat',
		'fk_product',
		'statut',
		'label',
		'description',
		'fk_remise_except',
		'date_commande',
		'date_ouverture_prevue',
		'date_ouverture',
		'date_fin_validite',
		'date_cloture',
		'vat_src_code',
		'tva_tx',
		'localtax1_tx',
		'localtax1_type',
		'localtax2_tx',
		'localtax2_type',
		'qty',
		'remise_percent',
		'subprice',
		'price_ht',
		'remise',
		'total_ht',
		'total_tva',
		'total_localtax1',
		'total_localtax2',
		'total_ttc',
		'product_type',
		'info_bits',
		'rang',
		'buy_price_ht',
		'fk_product_fournisseur_price',
		'fk_user_author',
		'fk_user_ouverture',
		'fk_user_cloture',
		'commentaire',
		'fk_unit',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_subprice',
		'multicurrency_total_ht',
		'multicurrency_total_tva',
		'multicurrency_total_ttc'
	];

	public function llx_contrat()
	{
		return $this->belongsTo(LlxContrat::class, 'fk_contrat');
	}

	public function llx_product()
	{
		return $this->belongsTo(LlxProduct::class, 'fk_product');
	}

	public function llx_c_unit()
	{
		return $this->belongsTo(LlxCUnit::class, 'fk_unit');
	}

	public function llx_contratdet_logs()
	{
		return $this->hasMany(LlxContratdetLog::class, 'fk_contratdet');
	}
}
