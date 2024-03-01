<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCommandeFournisseur
 *
 * @property int $rowid
 * @property string $ref
 * @property int $entity
 * @property string|null $ref_ext
 * @property string|null $ref_supplier
 * @property int $fk_soc
 * @property int|null $fk_projet
 * @property Carbon|null $tms
 * @property Carbon|null $date_creation
 * @property Carbon|null $date_valid
 * @property Carbon|null $date_approve
 * @property Carbon|null $date_approve2
 * @property Carbon|null $date_commande
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property int|null $fk_user_approve
 * @property int|null $fk_user_approve2
 * @property int $source
 * @property int|null $fk_statut
 * @property int|null $billed
 * @property float|null $amount_ht
 * @property float|null $remise_percent
 * @property float|null $remise
 * @property float|null $total_tva
 * @property float|null $localtax1
 * @property float|null $localtax2
 * @property float|null $total_ht
 * @property float|null $total_ttc
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property Carbon|null $date_livraison
 * @property int|null $fk_account
 * @property int|null $fk_cond_reglement
 * @property int|null $fk_mode_reglement
 * @property int|null $fk_input_method
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
 * @property LlxSociete $llx_societe
 *
 * @package App\Models
 */
class LlxCommandeFournisseur extends Model
{
	protected $table = 'llx_commande_fournisseur';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_soc' => 'int',
		'fk_projet' => 'int',
		'tms' => 'datetime',
		'date_creation' => 'datetime',
		'date_valid' => 'datetime',
		'date_approve' => 'datetime',
		'date_approve2' => 'datetime',
		'date_commande' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_user_approve' => 'int',
		'fk_user_approve2' => 'int',
		'source' => 'int',
		'fk_statut' => 'int',
		'billed' => 'int',
		'amount_ht' => 'float',
		'remise_percent' => 'float',
		'remise' => 'float',
		'total_tva' => 'float',
		'localtax1' => 'float',
		'localtax2' => 'float',
		'total_ht' => 'float',
		'total_ttc' => 'float',
		'date_livraison' => 'datetime',
		'fk_account' => 'int',
		'fk_cond_reglement' => 'int',
		'fk_mode_reglement' => 'int',
		'fk_input_method' => 'int',
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
		'ref_supplier',
		'fk_soc',
		'fk_projet',
		'tms',
		'date_creation',
		'date_valid',
		'date_approve',
		'date_approve2',
		'date_commande',
		'fk_user_author',
		'fk_user_modif',
		'fk_user_valid',
		'fk_user_approve',
		'fk_user_approve2',
		'source',
		'fk_statut',
		'billed',
		'amount_ht',
		'remise_percent',
		'remise',
		'total_tva',
		'localtax1',
		'localtax2',
		'total_ht',
		'total_ttc',
		'note_private',
		'note_public',
		'model_pdf',
		'last_main_doc',
		'date_livraison',
		'fk_account',
		'fk_cond_reglement',
		'fk_mode_reglement',
		'fk_input_method',
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

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}
}
