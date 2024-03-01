<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUserRight
 *
 * @property int $rowid
 * @property int $entity
 * @property int $fk_user
 * @property int $fk_id
 *
 * @property LlxUser $llx_user
 *
 * @package App\Models
 */
class LlxUserRight extends Model
{
	protected $table = 'llx_user_rights';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_user' => 'int',
		'fk_id' => 'int'
	];

	protected $fillable = [
		'entity',
		'fk_user',
		'fk_id'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user');
	}
}
