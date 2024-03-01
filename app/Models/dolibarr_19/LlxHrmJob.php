<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHrmJob
 *
 * @property int $rowid
 * @property string $label
 * @property string|null $description
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property string|null $deplacement
 * @property string|null $note_public
 * @property string|null $note_private
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 *
 * @package App\Models
 */
class LlxHrmJob extends Model
{
	protected $table = 'llx_hrm_job';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'label',
		'description',
		'date_creation',
		'tms',
		'deplacement',
		'note_public',
		'note_private',
		'fk_user_creat',
		'fk_user_modif'
	];
}
