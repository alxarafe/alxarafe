<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxRecruitmentRecruitmentcandidature
 *
 * @property int $rowid
 * @property int $entity
 * @property string $ref
 * @property int|null $fk_recruitmentjobposition
 * @property string|null $description
 * @property string|null $note_public
 * @property string|null $note_private
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int|null $fk_user
 * @property string|null $import_key
 * @property string|null $model_pdf
 * @property int $status
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $email
 * @property string|null $phone
 * @property Carbon|null $date_birth
 * @property int|null $remuneration_requested
 * @property int|null $remuneration_proposed
 * @property string|null $email_msgid
 * @property Carbon|null $email_date
 * @property int|null $fk_recruitment_origin
 *
 * @property LlxUser $llx_user
 *
 * @package App\Models
 */
class LlxRecruitmentRecruitmentcandidature extends Model
{
	protected $table = 'llx_recruitment_recruitmentcandidature';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_recruitmentjobposition' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_user' => 'int',
		'status' => 'int',
		'date_birth' => 'datetime',
		'remuneration_requested' => 'int',
		'remuneration_proposed' => 'int',
		'email_date' => 'datetime',
		'fk_recruitment_origin' => 'int'
	];

	protected $fillable = [
		'entity',
		'ref',
		'fk_recruitmentjobposition',
		'description',
		'note_public',
		'note_private',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'fk_user',
		'import_key',
		'model_pdf',
		'status',
		'firstname',
		'lastname',
		'email',
		'phone',
		'date_birth',
		'remuneration_requested',
		'remuneration_proposed',
		'email_msgid',
		'email_date',
		'fk_recruitment_origin'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}
}
