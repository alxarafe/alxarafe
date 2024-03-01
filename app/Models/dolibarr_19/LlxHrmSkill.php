<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHrmSkill
 *
 * @property int $rowid
 * @property string|null $label
 * @property string|null $description
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int $required_level
 * @property int $date_validite
 * @property float $temps_theorique
 * @property int $skill_type
 * @property string|null $note_public
 * @property string|null $note_private
 *
 * @property LlxUser $llx_user
 * @property Collection|LlxHrmSkilldet[] $llx_hrm_skilldets
 * @property Collection|LlxHrmSkillrank[] $llx_hrm_skillranks
 *
 * @package App\Models
 */
class LlxHrmSkill extends Model
{
	protected $table = 'llx_hrm_skill';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'required_level' => 'int',
		'date_validite' => 'int',
		'temps_theorique' => 'float',
		'skill_type' => 'int'
	];

	protected $fillable = [
		'label',
		'description',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'required_level',
		'date_validite',
		'temps_theorique',
		'skill_type',
		'note_public',
		'note_private'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}

	public function llx_hrm_skilldets()
	{
		return $this->hasMany(LlxHrmSkilldet::class, 'fk_skill');
	}

	public function llx_hrm_skillranks()
	{
		return $this->hasMany(LlxHrmSkillrank::class, 'fk_skill');
	}
}
