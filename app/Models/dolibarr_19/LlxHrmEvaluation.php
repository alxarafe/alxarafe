<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHrmEvaluation
 *
 * @property int $rowid
 * @property string $ref
 * @property string|null $label
 * @property string|null $description
 * @property string|null $note_public
 * @property string|null $note_private
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $import_key
 * @property int $status
 * @property Carbon|null $date_eval
 * @property int $fk_user
 * @property int $fk_job
 *
 * @property LlxUser $llx_user
 * @property Collection|LlxHrmEvaluationdet[] $llx_hrm_evaluationdets
 *
 * @package App\Models
 */
class LlxHrmEvaluation extends Model
{
	protected $table = 'llx_hrm_evaluation';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'status' => 'int',
		'date_eval' => 'datetime',
		'fk_user' => 'int',
		'fk_job' => 'int'
	];

	protected $fillable = [
		'ref',
		'label',
		'description',
		'note_public',
		'note_private',
		'model_pdf',
		'last_main_doc',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'import_key',
		'status',
		'date_eval',
		'fk_user',
		'fk_job'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}

	public function llx_hrm_evaluationdets()
	{
		return $this->hasMany(LlxHrmEvaluationdet::class, 'fk_evaluation');
	}
}
