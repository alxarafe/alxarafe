<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUsergroupRight
 *
 * @property int $rowid
 * @property int $entity
 * @property int $fk_usergroup
 * @property int $fk_id
 *
 * @property LlxUsergroup $llx_usergroup
 *
 * @package App\Models
 */
class LlxUsergroupRight extends Model
{
	protected $table = 'llx_usergroup_rights';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_usergroup' => 'int',
		'fk_id' => 'int'
	];

	protected $fillable = [
		'entity',
		'fk_usergroup',
		'fk_id'
	];

	public function llx_usergroup()
	{
		return $this->belongsTo(LlxUsergroup::class, 'fk_usergroup');
	}
}
