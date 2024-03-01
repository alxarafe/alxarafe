<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFactureFournRec
 *
 * @property int $rowid
 * @property string $titre
 * @property string $ref_supplier
 * @property int $entity
 * @property int|null $subtype
 * @property int $fk_soc
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int|null $suspended
 * @property string|null $libelle
 * @property float $amount
 * @property float|null $remise
 * @property string|null $vat_src_code
 * @property float|null $localtax1
 * @property float|null $localtax2
 * @property float|null $total_ht
 * @property float|null $total_tva
 * @property float|null $total_ttc
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_projet
 * @property int|null $fk_account
 * @property int|null $fk_cond_reglement
 * @property int|null $fk_mode_reglement
 * @property Carbon|null $date_lim_reglement
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $modelpdf
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_tx
 * @property float|null $multicurrency_total_ht
 * @property float|null $multicurrency_total_tva
 * @property float|null $multicurrency_total_ttc
 * @property int|null $usenewprice
 * @property int|null $frequency
 * @property string|null $unit_frequency
 * @property Carbon|null $date_when
 * @property Carbon|null $date_last_gen
 * @property int|null $nb_gen_done
 * @property int|null $nb_gen_max
 * @property int|null $auto_validate
 * @property int|null $generate_pdf
 *
 * @property LlxProjet|null $llx_projet
 * @property LlxSociete $llx_societe
 * @property LlxUser|null $llx_user
 *
 * @package App\Models
 */
class LlxFactureFournRec extends Model
{
	protected $table = 'llx_facture_fourn_rec';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'subtype' => 'int',
		'fk_soc' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'suspended' => 'int',
		'amount' => 'float',
		'remise' => 'float',
		'localtax1' => 'float',
		'localtax2' => 'float',
		'total_ht' => 'float',
		'total_tva' => 'float',
		'total_ttc' => 'float',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_projet' => 'int',
		'fk_account' => 'int',
		'fk_cond_reglement' => 'int',
		'fk_mode_reglement' => 'int',
		'date_lim_reglement' => 'datetime',
		'fk_multicurrency' => 'int',
		'multicurrency_tx' => 'float',
		'multicurrency_total_ht' => 'float',
		'multicurrency_total_tva' => 'float',
		'multicurrency_total_ttc' => 'float',
		'usenewprice' => 'int',
		'frequency' => 'int',
		'date_when' => 'datetime',
		'date_last_gen' => 'datetime',
		'nb_gen_done' => 'int',
		'nb_gen_max' => 'int',
		'auto_validate' => 'int',
		'generate_pdf' => 'int'
	];

	protected $fillable = [
		'titre',
		'ref_supplier',
		'entity',
		'subtype',
		'fk_soc',
		'datec',
		'tms',
		'suspended',
		'libelle',
		'amount',
		'remise',
		'vat_src_code',
		'localtax1',
		'localtax2',
		'total_ht',
		'total_tva',
		'total_ttc',
		'fk_user_author',
		'fk_user_modif',
		'fk_projet',
		'fk_account',
		'fk_cond_reglement',
		'fk_mode_reglement',
		'date_lim_reglement',
		'note_private',
		'note_public',
		'modelpdf',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_tx',
		'multicurrency_total_ht',
		'multicurrency_total_tva',
		'multicurrency_total_ttc',
		'usenewprice',
		'frequency',
		'unit_frequency',
		'date_when',
		'date_last_gen',
		'nb_gen_done',
		'nb_gen_max',
		'auto_validate',
		'generate_pdf'
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
		return $this->belongsTo(LlxUser::class, 'fk_user_author');
	}
}
