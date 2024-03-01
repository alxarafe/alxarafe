<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHrmSkillrank
 *
 * @property int $rowid
 * @property int $fk_skill
 * @property int $rankorder
 * @property int $fk_object
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string $objecttype
 *
 * @property LlxHrmSkill $llx_hrm_skill
 * @property LlxUser $llx_user
 *
 * @package App\Models
 */
class LlxHrmSkillrank extends Model
{
	protected $table = 'llx_hrm_skillrank';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_skill' => 'int',
		'rankorder' => 'int',
		'fk_object' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'fk_skill',
		'rankorder',
		'fk_object',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'objecttype'
	];

	public function llx_hrm_skill()
	{
		return $this->belongsTo(LlxHrmSkill::class, 'fk_skill');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}
}
