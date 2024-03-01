<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxEstablishment
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $ref
 * @property string $label
 * @property string|null $name
 * @property string|null $address
 * @property string|null $zip
 * @property string|null $town
 * @property int|null $fk_state
 * @property int|null $fk_country
 * @property string|null $profid1
 * @property string|null $profid2
 * @property string|null $profid3
 * @property string|null $phone
 * @property int $fk_user_author
 * @property int|null $fk_user_mod
 * @property Carbon $datec
 * @property Carbon $tms
 * @property int|null $status
 *
 * @property Collection|LlxRecruitmentRecruitmentjobposition[] $llx_recruitment_recruitmentjobpositions
 *
 * @package App\Models
 */
class LlxEstablishment extends Model
{
	protected $table = 'llx_establishment';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_state' => 'int',
		'fk_country' => 'int',
		'fk_user_author' => 'int',
		'fk_user_mod' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'entity',
		'ref',
		'label',
		'name',
		'address',
		'zip',
		'town',
		'fk_state',
		'fk_country',
		'profid1',
		'profid2',
		'profid3',
		'phone',
		'fk_user_author',
		'fk_user_mod',
		'datec',
		'tms',
		'status'
	];

	public function llx_recruitment_recruitmentjobpositions()
	{
		return $this->hasMany(LlxRecruitmentRecruitmentjobposition::class, 'fk_establishment');
	}
}
