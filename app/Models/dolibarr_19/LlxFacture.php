<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFacture
 *
 * @property int $rowid
 * @property string $ref
 * @property int $entity
 * @property string|null $ref_ext
 * @property string|null $ref_client
 * @property int $type
 * @property int|null $subtype
 * @property int $fk_soc
 * @property Carbon|null $datec
 * @property Carbon|null $datef
 * @property Carbon|null $date_pointoftax
 * @property Carbon|null $date_valid
 * @property Carbon|null $tms
 * @property Carbon|null $date_closing
 * @property int $paye
 * @property float|null $remise_percent
 * @property float|null $remise_absolue
 * @property float|null $remise
 * @property string|null $close_code
 * @property float|null $close_missing_amount
 * @property string|null $close_note
 * @property float|null $total_tva
 * @property float|null $localtax1
 * @property float|null $localtax2
 * @property float|null $revenuestamp
 * @property float|null $total_ht
 * @property float|null $total_ttc
 * @property int $fk_statut
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property int|null $fk_user_closing
 * @property string|null $module_source
 * @property string|null $pos_source
 * @property int|null $fk_fac_rec_source
 * @property int|null $fk_facture_source
 * @property int|null $fk_projet
 * @property string|null $increment
 * @property int|null $fk_account
 * @property string|null $fk_currency
 * @property int $fk_cond_reglement
 * @property int|null $fk_mode_reglement
 * @property Carbon|null $date_lim_reglement
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property int|null $fk_incoterms
 * @property string|null $location_incoterms
 * @property int|null $fk_transport_mode
 * @property float|null $prorata_discount
 * @property int|null $situation_cycle_ref
 * @property int|null $situation_counter
 * @property int|null $situation_final
 * @property float|null $retained_warranty
 * @property Carbon|null $retained_warranty_date_limit
 * @property int|null $retained_warranty_fk_cond_reglement
 * @property string|null $import_key
 * @property string|null $extraparams
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_tx
 * @property float|null $multicurrency_total_ht
 * @property float|null $multicurrency_total_tva
 * @property float|null $multicurrency_total_ttc
 *
 * @property LlxFacture|null $llx_facture
 * @property LlxProjet|null $llx_projet
 * @property LlxSociete $llx_societe
 * @property LlxUser|null $llx_user
 * @property Collection|LlxFacture[] $llx_factures
 * @property Collection|LlxFacturedet[] $llx_facturedets
 * @property Collection|LlxPaiementFacture[] $llx_paiement_factures
 * @property Collection|LlxSocieteRemiseExcept[] $llx_societe_remise_excepts
 *
 * @package App\Models
 */
class LlxFacture extends Model
{
	protected $table = 'llx_facture';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'type' => 'int',
		'subtype' => 'int',
		'fk_soc' => 'int',
		'datec' => 'datetime',
		'datef' => 'datetime',
		'date_pointoftax' => 'datetime',
		'date_valid' => 'datetime',
		'tms' => 'datetime',
		'date_closing' => 'datetime',
		'paye' => 'int',
		'remise_percent' => 'float',
		'remise_absolue' => 'float',
		'remise' => 'float',
		'close_missing_amount' => 'float',
		'total_tva' => 'float',
		'localtax1' => 'float',
		'localtax2' => 'float',
		'revenuestamp' => 'float',
		'total_ht' => 'float',
		'total_ttc' => 'float',
		'fk_statut' => 'int',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_user_closing' => 'int',
		'fk_fac_rec_source' => 'int',
		'fk_facture_source' => 'int',
		'fk_projet' => 'int',
		'fk_account' => 'int',
		'fk_cond_reglement' => 'int',
		'fk_mode_reglement' => 'int',
		'date_lim_reglement' => 'datetime',
		'fk_incoterms' => 'int',
		'fk_transport_mode' => 'int',
		'prorata_discount' => 'float',
		'situation_cycle_ref' => 'int',
		'situation_counter' => 'int',
		'situation_final' => 'int',
		'retained_warranty' => 'float',
		'retained_warranty_date_limit' => 'datetime',
		'retained_warranty_fk_cond_reglement' => 'int',
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
		'type',
		'subtype',
		'fk_soc',
		'datec',
		'datef',
		'date_pointoftax',
		'date_valid',
		'tms',
		'date_closing',
		'paye',
		'remise_percent',
		'remise_absolue',
		'remise',
		'close_code',
		'close_missing_amount',
		'close_note',
		'total_tva',
		'localtax1',
		'localtax2',
		'revenuestamp',
		'total_ht',
		'total_ttc',
		'fk_statut',
		'fk_user_author',
		'fk_user_modif',
		'fk_user_valid',
		'fk_user_closing',
		'module_source',
		'pos_source',
		'fk_fac_rec_source',
		'fk_facture_source',
		'fk_projet',
		'increment',
		'fk_account',
		'fk_currency',
		'fk_cond_reglement',
		'fk_mode_reglement',
		'date_lim_reglement',
		'note_private',
		'note_public',
		'model_pdf',
		'last_main_doc',
		'fk_incoterms',
		'location_incoterms',
		'fk_transport_mode',
		'prorata_discount',
		'situation_cycle_ref',
		'situation_counter',
		'situation_final',
		'retained_warranty',
		'retained_warranty_date_limit',
		'retained_warranty_fk_cond_reglement',
		'import_key',
		'extraparams',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_tx',
		'multicurrency_total_ht',
		'multicurrency_total_tva',
		'multicurrency_total_ttc'
	];

	public function llx_facture()
	{
		return $this->belongsTo(LlxFacture::class, 'fk_facture_source');
	}

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

	public function llx_factures()
	{
		return $this->hasMany(LlxFacture::class, 'fk_facture_source');
	}

	public function llx_facturedets()
	{
		return $this->hasMany(LlxFacturedet::class, 'fk_facture');
	}

	public function llx_paiement_factures()
	{
		return $this->hasMany(LlxPaiementFacture::class, 'fk_facture');
	}

	public function llx_societe_remise_excepts()
	{
		return $this->hasMany(LlxSocieteRemiseExcept::class, 'fk_facture_source');
	}
}
