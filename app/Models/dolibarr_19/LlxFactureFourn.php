<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFactureFourn
 *
 * @property int $rowid
 * @property string $ref
 * @property string $ref_supplier
 * @property int $entity
 * @property string|null $ref_ext
 * @property int $type
 * @property int|null $subtype
 * @property int $fk_soc
 * @property Carbon|null $datec
 * @property Carbon|null $datef
 * @property Carbon|null $date_pointoftax
 * @property Carbon|null $date_valid
 * @property Carbon|null $tms
 * @property Carbon|null $date_closing
 * @property string|null $libelle
 * @property int $paye
 * @property float $amount
 * @property float|null $remise
 * @property string|null $close_code
 * @property float|null $close_missing_amount
 * @property string|null $close_note
 * @property int|null $vat_reverse_charge
 * @property float|null $tva
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
 * @property int|null $fk_fac_rec_source
 * @property int|null $fk_facture_source
 * @property int|null $fk_projet
 * @property int|null $fk_account
 * @property int|null $fk_cond_reglement
 * @property int|null $fk_mode_reglement
 * @property Carbon|null $date_lim_reglement
 * @property string|null $note_private
 * @property string|null $note_public
 * @property int|null $fk_incoterms
 * @property string|null $location_incoterms
 * @property int|null $fk_transport_mode
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
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
 * @property Collection|LlxFactureFournDet[] $llx_facture_fourn_dets
 * @property Collection|LlxSocieteRemiseExcept[] $llx_societe_remise_excepts
 *
 * @package App\Models
 */
class LlxFactureFourn extends Model
{
	protected $table = 'llx_facture_fourn';
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
		'amount' => 'float',
		'remise' => 'float',
		'close_missing_amount' => 'float',
		'vat_reverse_charge' => 'int',
		'tva' => 'float',
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
		'fk_multicurrency' => 'int',
		'multicurrency_tx' => 'float',
		'multicurrency_total_ht' => 'float',
		'multicurrency_total_tva' => 'float',
		'multicurrency_total_ttc' => 'float'
	];

	protected $fillable = [
		'ref',
		'ref_supplier',
		'entity',
		'ref_ext',
		'type',
		'subtype',
		'fk_soc',
		'datec',
		'datef',
		'date_pointoftax',
		'date_valid',
		'tms',
		'date_closing',
		'libelle',
		'paye',
		'amount',
		'remise',
		'close_code',
		'close_missing_amount',
		'close_note',
		'vat_reverse_charge',
		'tva',
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
		'fk_fac_rec_source',
		'fk_facture_source',
		'fk_projet',
		'fk_account',
		'fk_cond_reglement',
		'fk_mode_reglement',
		'date_lim_reglement',
		'note_private',
		'note_public',
		'fk_incoterms',
		'location_incoterms',
		'fk_transport_mode',
		'model_pdf',
		'last_main_doc',
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

	public function llx_facture_fourn_dets()
	{
		return $this->hasMany(LlxFactureFournDet::class, 'fk_facture_fourn');
	}

	public function llx_societe_remise_excepts()
	{
		return $this->hasMany(LlxSocieteRemiseExcept::class, 'fk_invoice_supplier');
	}
}
