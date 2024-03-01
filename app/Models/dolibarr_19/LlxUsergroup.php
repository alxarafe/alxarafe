<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUsergroup
 *
 * @property int $rowid
 * @property string $nom
 * @property int $entity
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property string|null $note
 * @property string|null $model_pdf
 *
 * @property Collection|LlxUsergroupRight[] $llx_usergroup_rights
 * @property Collection|LlxUsergroupUser[] $llx_usergroup_users
 *
 * @package App\Models
 */
class LlxUsergroup extends Model
{
	protected $table = 'llx_usergroup';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'nom',
		'entity',
		'datec',
		'tms',
		'note',
		'model_pdf'
	];

	public function llx_usergroup_rights()
	{
		return $this->hasMany(LlxUsergroupRight::class, 'fk_usergroup');
	}

	public function llx_usergroup_users()
	{
		return $this->hasMany(LlxUsergroupUser::class, 'fk_usergroup');
	}
}
