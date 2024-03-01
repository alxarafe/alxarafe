<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUsergroupUser
 *
 * @property int $rowid
 * @property int $entity
 * @property int $fk_user
 * @property int $fk_usergroup
 *
 * @property LlxUser $llx_user
 * @property LlxUsergroup $llx_usergroup
 *
 * @package App\Models
 */
class LlxUsergroupUser extends Model
{
	protected $table = 'llx_usergroup_user';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_user' => 'int',
		'fk_usergroup' => 'int'
	];

	protected $fillable = [
		'entity',
		'fk_user',
		'fk_usergroup'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user');
	}

	public function llx_usergroup()
	{
		return $this->belongsTo(LlxUsergroup::class, 'fk_usergroup');
	}
}
