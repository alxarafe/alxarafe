<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProjet
 *
 * @property int $rowid
 * @property int|null $fk_project
 * @property int|null $fk_soc
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property Carbon|null $dateo
 * @property Carbon|null $datee
 * @property string|null $ref
 * @property int $entity
 * @property string $title
 * @property string|null $description
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int|null $public
 * @property int $fk_statut
 * @property int|null $fk_opp_status
 * @property float|null $opp_percent
 * @property int|null $fk_opp_status_end
 * @property Carbon|null $date_close
 * @property int|null $fk_user_close
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $email_msgid
 * @property float|null $opp_amount
 * @property float|null $budget_amount
 * @property int|null $usage_opportunity
 * @property int|null $usage_task
 * @property int|null $usage_bill_time
 * @property int|null $usage_organize_event
 * @property Carbon|null $date_start_event
 * @property Carbon|null $date_end_event
 * @property string|null $location
 * @property int|null $accept_conference_suggestions
 * @property int|null $accept_booth_suggestions
 * @property int|null $max_attendees
 * @property float|null $price_registration
 * @property float|null $price_booth
 * @property string|null $model_pdf
 * @property string|null $ip
 * @property string|null $last_main_doc
 * @property string|null $import_key
 * @property string|null $extraparams
 *
 * @property LlxSociete|null $llx_societe
 * @property Collection|LlxCategorieProject[] $llx_categorie_projects
 * @property Collection|LlxCommande[] $llx_commandes
 * @property Collection|LlxFacture[] $llx_factures
 * @property Collection|LlxFactureFourn[] $llx_facture_fourns
 * @property Collection|LlxFactureFournRec[] $llx_facture_fourn_recs
 * @property Collection|LlxFactureRec[] $llx_facture_recs
 * @property Collection|LlxFichinterRec[] $llx_fichinter_recs
 * @property Collection|LlxProjetTask[] $llx_projet_tasks
 * @property Collection|LlxPropal[] $llx_propals
 *
 * @package App\Models
 */
class LlxProjet extends Model
{
	protected $table = 'llx_projet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_project' => 'int',
		'fk_soc' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'dateo' => 'datetime',
		'datee' => 'datetime',
		'entity' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'public' => 'int',
		'fk_statut' => 'int',
		'fk_opp_status' => 'int',
		'opp_percent' => 'float',
		'fk_opp_status_end' => 'int',
		'date_close' => 'datetime',
		'fk_user_close' => 'int',
		'opp_amount' => 'float',
		'budget_amount' => 'float',
		'usage_opportunity' => 'int',
		'usage_task' => 'int',
		'usage_bill_time' => 'int',
		'usage_organize_event' => 'int',
		'date_start_event' => 'datetime',
		'date_end_event' => 'datetime',
		'accept_conference_suggestions' => 'int',
		'accept_booth_suggestions' => 'int',
		'max_attendees' => 'int',
		'price_registration' => 'float',
		'price_booth' => 'float'
	];

	protected $fillable = [
		'fk_project',
		'fk_soc',
		'datec',
		'tms',
		'dateo',
		'datee',
		'ref',
		'entity',
		'title',
		'description',
		'fk_user_creat',
		'fk_user_modif',
		'public',
		'fk_statut',
		'fk_opp_status',
		'opp_percent',
		'fk_opp_status_end',
		'date_close',
		'fk_user_close',
		'note_private',
		'note_public',
		'email_msgid',
		'opp_amount',
		'budget_amount',
		'usage_opportunity',
		'usage_task',
		'usage_bill_time',
		'usage_organize_event',
		'date_start_event',
		'date_end_event',
		'location',
		'accept_conference_suggestions',
		'accept_booth_suggestions',
		'max_attendees',
		'price_registration',
		'price_booth',
		'model_pdf',
		'ip',
		'last_main_doc',
		'import_key',
		'extraparams'
	];

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}

	public function llx_categorie_projects()
	{
		return $this->hasMany(LlxCategorieProject::class, 'fk_project');
	}

	public function llx_commandes()
	{
		return $this->hasMany(LlxCommande::class, 'fk_projet');
	}

	public function llx_factures()
	{
		return $this->hasMany(LlxFacture::class, 'fk_projet');
	}

	public function llx_facture_fourns()
	{
		return $this->hasMany(LlxFactureFourn::class, 'fk_projet');
	}

	public function llx_facture_fourn_recs()
	{
		return $this->hasMany(LlxFactureFournRec::class, 'fk_projet');
	}

	public function llx_facture_recs()
	{
		return $this->hasMany(LlxFactureRec::class, 'fk_projet');
	}

	public function llx_fichinter_recs()
	{
		return $this->hasMany(LlxFichinterRec::class, 'fk_projet');
	}

	public function llx_projet_tasks()
	{
		return $this->hasMany(LlxProjetTask::class, 'fk_projet');
	}

	public function llx_propals()
	{
		return $this->hasMany(LlxPropal::class, 'fk_projet');
	}
}
