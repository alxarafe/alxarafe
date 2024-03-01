<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCommande
 *
 * @property int $rowid
 * @property string $ref
 * @property int $entity
 * @property string|null $ref_ext
 * @property string|null $ref_client
 * @property int $fk_soc
 * @property int|null $fk_projet
 * @property Carbon|null $tms
 * @property Carbon|null $date_creation
 * @property Carbon|null $date_valid
 * @property Carbon|null $date_cloture
 * @property Carbon|null $date_commande
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property int|null $fk_user_cloture
 * @property int|null $source
 * @property int|null $fk_statut
 * @property float|null $amount_ht
 * @property float|null $remise_percent
 * @property float|null $remise_absolue
 * @property float|null $remise
 * @property float|null $total_tva
 * @property float|null $localtax1
 * @property float|null $localtax2
 * @property float|null $revenuestamp
 * @property float|null $total_ht
 * @property float|null $total_ttc
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property string|null $module_source
 * @property string|null $pos_source
 * @property int|null $facture
 * @property int|null $fk_account
 * @property string|null $fk_currency
 * @property int|null $fk_cond_reglement
 * @property string|null $deposit_percent
 * @property int|null $fk_mode_reglement
 * @property Carbon|null $date_livraison
 * @property int|null $fk_shipping_method
 * @property int|null $fk_warehouse
 * @property int|null $fk_availability
 * @property int|null $fk_input_reason
 * @property int|null $fk_delivery_address
 * @property int|null $fk_incoterms
 * @property string|null $location_incoterms
 * @property string|null $import_key
 * @property string|null $extraparams
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_tx
 * @property float|null $multicurrency_total_ht
 * @property float|null $multicurrency_total_tva
 * @property float|null $multicurrency_total_ttc
 *
 * @property LlxProjet|null $llx_projet
 * @property LlxSociete $llx_societe
 * @property LlxUser|null $llx_user
 * @property Collection|LlxCommandedet[] $llx_commandedets
 *
 * @package App\Models
 */
class LlxCommande extends Model
{
	protected $table = 'llx_commande';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_soc' => 'int',
		'fk_projet' => 'int',
		'tms' => 'datetime',
		'date_creation' => 'datetime',
		'date_valid' => 'datetime',
		'date_cloture' => 'datetime',
		'date_commande' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_user_cloture' => 'int',
		'source' => 'int',
		'fk_statut' => 'int',
		'amount_ht' => 'float',
		'remise_percent' => 'float',
		'remise_absolue' => 'float',
		'remise' => 'float',
		'total_tva' => 'float',
		'localtax1' => 'float',
		'localtax2' => 'float',
		'revenuestamp' => 'float',
		'total_ht' => 'float',
		'total_ttc' => 'float',
		'facture' => 'int',
		'fk_account' => 'int',
		'fk_cond_reglement' => 'int',
		'fk_mode_reglement' => 'int',
		'date_livraison' => 'datetime',
		'fk_shipping_method' => 'int',
		'fk_warehouse' => 'int',
		'fk_availability' => 'int',
		'fk_input_reason' => 'int',
		'fk_delivery_address' => 'int',
		'fk_incoterms' => 'int',
		'fk_multicurrency' => 'int',
		'multicurrency_tx' => 'float',
		'multicurrency_total_ht' => 'float',
		'multicurrency_total_tva' => 'float',
		'multicurrency_total_ttc' => 'float'
	];

	protected $fillable = [
		'ref',
		'entity',
		'ref_ext',
		'ref_client',
		'fk_soc',
		'fk_projet',
		'tms',
		'date_creation',
		'date_valid',
		'date_cloture',
		'date_commande',
		'fk_user_author',
		'fk_user_modif',
		'fk_user_valid',
		'fk_user_cloture',
		'source',
		'fk_statut',
		'amount_ht',
		'remise_percent',
		'remise_absolue',
		'remise',
		'total_tva',
		'localtax1',
		'localtax2',
		'revenuestamp',
		'total_ht',
		'total_ttc',
		'note_private',
		'note_public',
		'model_pdf',
		'last_main_doc',
		'module_source',
		'pos_source',
		'facture',
		'fk_account',
		'fk_currency',
		'fk_cond_reglement',
		'deposit_percent',
		'fk_mode_reglement',
		'date_livraison',
		'fk_shipping_method',
		'fk_warehouse',
		'fk_availability',
		'fk_input_reason',
		'fk_delivery_address',
		'fk_incoterms',
		'location_incoterms',
		'import_key',
		'extraparams',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_tx',
		'multicurrency_total_ht',
		'multicurrency_total_tva',
		'multicurrency_total_ttc'
	];

	public function llx_projet()
	{
		return $this->belongsTo(LlxProjet::class, 'fk_projet');
	}

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_valid');
	}

	public function llx_commandedets()
	{
		return $this->hasMany(LlxCommandedet::class, 'fk_commande');
	}
}
