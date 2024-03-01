<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProjetTask
 *
 * @property int $rowid
 * @property string|null $ref
 * @property int $entity
 * @property int $fk_projet
 * @property int $fk_task_parent
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property Carbon|null $dateo
 * @property Carbon|null $datee
 * @property Carbon|null $datev
 * @property string $label
 * @property string|null $description
 * @property float|null $duration_effective
 * @property float|null $planned_workload
 * @property int|null $progress
 * @property int|null $priority
 * @property float|null $budget_amount
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property int $fk_statut
 * @property string|null $note_private
 * @property string|null $note_public
 * @property int|null $rang
 * @property string|null $model_pdf
 * @property string|null $import_key
 * @property int $status
 *
 * @property LlxProjet $llx_projet
 * @property LlxUser|null $llx_user
 *
 * @package App\Models
 */
class LlxProjetTask extends Model
{
	protected $table = 'llx_projet_task';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_projet' => 'int',
		'fk_task_parent' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'dateo' => 'datetime',
		'datee' => 'datetime',
		'datev' => 'datetime',
		'duration_effective' => 'float',
		'planned_workload' => 'float',
		'progress' => 'int',
		'priority' => 'int',
		'budget_amount' => 'float',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_statut' => 'int',
		'rang' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'ref',
		'entity',
		'fk_projet',
		'fk_task_parent',
		'datec',
		'tms',
		'dateo',
		'datee',
		'datev',
		'label',
		'description',
		'duration_effective',
		'planned_workload',
		'progress',
		'priority',
		'budget_amount',
		'fk_user_creat',
		'fk_user_modif',
		'fk_user_valid',
		'fk_statut',
		'note_private',
		'note_public',
		'rang',
		'model_pdf',
		'import_key',
		'status'
	];

	public function llx_projet()
	{
		return $this->belongsTo(LlxProjet::class, 'fk_projet');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_valid');
	}
}
