<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxRecruitmentRecruitmentjobposition
 *
 * @property int $rowid
 * @property string $ref
 * @property int $entity
 * @property string $label
 * @property int $qty
 * @property int|null $fk_soc
 * @property int|null $fk_project
 * @property int|null $fk_user_recruiter
 * @property string|null $email_recruiter
 * @property int|null $fk_user_supervisor
 * @property int|null $fk_establishment
 * @property Carbon|null $date_planned
 * @property string|null $remuneration_suggested
 * @property string|null $description
 * @property string|null $note_public
 * @property string|null $note_private
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $last_main_doc
 * @property string|null $import_key
 * @property string|null $model_pdf
 * @property int $status
 *
 * @property LlxEstablishment|null $llx_establishment
 * @property LlxUser|null $llx_user
 *
 * @package App\Models
 */
class LlxRecruitmentRecruitmentjobposition extends Model
{
	protected $table = 'llx_recruitment_recruitmentjobposition';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'qty' => 'int',
		'fk_soc' => 'int',
		'fk_project' => 'int',
		'fk_user_recruiter' => 'int',
		'fk_user_supervisor' => 'int',
		'fk_establishment' => 'int',
		'date_planned' => 'datetime',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'ref',
		'entity',
		'label',
		'qty',
		'fk_soc',
		'fk_project',
		'fk_user_recruiter',
		'email_recruiter',
		'fk_user_supervisor',
		'fk_establishment',
		'date_planned',
		'remuneration_suggested',
		'description',
		'note_public',
		'note_private',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'last_main_doc',
		'import_key',
		'model_pdf',
		'status'
	];

	public function llx_establishment()
	{
		return $this->belongsTo(LlxEstablishment::class, 'fk_establishment');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_supervisor');
	}
}
