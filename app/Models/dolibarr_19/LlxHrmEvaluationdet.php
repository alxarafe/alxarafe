<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHrmEvaluationdet
 *
 * @property int $rowid
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int $fk_skill
 * @property int $fk_evaluation
 * @property int $rankorder
 * @property int $required_rank
 * @property string|null $comment
 * @property string|null $import_key
 *
 * @property LlxHrmEvaluation $llx_hrm_evaluation
 * @property LlxUser $llx_user
 *
 * @package App\Models
 */
class LlxHrmEvaluationdet extends Model
{
	protected $table = 'llx_hrm_evaluationdet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_skill' => 'int',
		'fk_evaluation' => 'int',
		'rankorder' => 'int',
		'required_rank' => 'int'
	];

	protected $fillable = [
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'fk_skill',
		'fk_evaluation',
		'rankorder',
		'required_rank',
		'comment',
		'import_key'
	];

	public function llx_hrm_evaluation()
	{
		return $this->belongsTo(LlxHrmEvaluation::class, 'fk_evaluation');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}
}
