<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHrmSkilldet
 *
 * @property int $rowid
 * @property int $fk_skill
 * @property int $rankorder
 * @property string|null $description
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 *
 * @property LlxHrmSkill $llx_hrm_skill
 * @property LlxUser $llx_user
 *
 * @package App\Models
 */
class LlxHrmSkilldet extends Model
{
	protected $table = 'llx_hrm_skilldet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_skill' => 'int',
		'rankorder' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'fk_skill',
		'rankorder',
		'description',
		'fk_user_creat',
		'fk_user_modif'
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
