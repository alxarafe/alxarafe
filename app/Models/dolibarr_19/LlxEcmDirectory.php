<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxEcmDirectory
 *
 * @property int $rowid
 * @property string $label
 * @property int $entity
 * @property int|null $fk_parent
 * @property string $description
 * @property int $cachenbofdoc
 * @property string|null $fullpath
 * @property string|null $extraparams
 * @property Carbon|null $date_c
 * @property Carbon|null $tms
 * @property int|null $fk_user_c
 * @property int|null $fk_user_m
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $acl
 *
 * @property LlxUser|null $llx_user
 *
 * @package App\Models
 */
class LlxEcmDirectory extends Model
{
	protected $table = 'llx_ecm_directories';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_parent' => 'int',
		'cachenbofdoc' => 'int',
		'date_c' => 'datetime',
		'tms' => 'datetime',
		'fk_user_c' => 'int',
		'fk_user_m' => 'int'
	];

	protected $fillable = [
		'label',
		'entity',
		'fk_parent',
		'description',
		'cachenbofdoc',
		'fullpath',
		'extraparams',
		'date_c',
		'tms',
		'fk_user_c',
		'fk_user_m',
		'note_private',
		'note_public',
		'acl'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_m');
	}
}
