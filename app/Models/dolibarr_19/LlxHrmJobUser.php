<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHrmJobUser
 *
 * @property int $rowid
 * @property string|null $description
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int|null $fk_contrat
 * @property int|null $fk_user
 * @property int $fk_job
 * @property Carbon|null $date_start
 * @property Carbon|null $date_end
 * @property string|null $abort_comment
 * @property string|null $note_public
 * @property string|null $note_private
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 *
 * @package App\Models
 */
class LlxHrmJobUser extends Model
{
	protected $table = 'llx_hrm_job_user';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_contrat' => 'int',
		'fk_user' => 'int',
		'fk_job' => 'int',
		'date_start' => 'datetime',
		'date_end' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'description',
		'date_creation',
		'tms',
		'fk_contrat',
		'fk_user',
		'fk_job',
		'date_start',
		'date_end',
		'abort_comment',
		'note_public',
		'note_private',
		'fk_user_creat',
		'fk_user_modif'
	];
}
