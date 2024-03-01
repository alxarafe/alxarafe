<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxHoliday
 *
 * @property int $rowid
 * @property string $ref
 * @property string|null $ref_ext
 * @property int $entity
 * @property int $fk_user
 * @property int|null $fk_user_create
 * @property int|null $fk_user_modif
 * @property int $fk_type
 * @property Carbon $date_create
 * @property string $description
 * @property Carbon $date_debut
 * @property Carbon $date_fin
 * @property int|null $halfday
 * @property float|null $nb_open_day
 * @property int $statut
 * @property int $fk_validator
 * @property Carbon|null $date_valid
 * @property int|null $fk_user_valid
 * @property Carbon|null $date_approval
 * @property int|null $fk_user_approve
 * @property Carbon|null $date_refuse
 * @property int|null $fk_user_refuse
 * @property Carbon|null $date_cancel
 * @property int|null $fk_user_cancel
 * @property string|null $detail_refuse
 * @property string|null $note_private
 * @property string|null $note_public
 * @property Carbon|null $tms
 * @property string|null $import_key
 * @property string|null $extraparams
 *
 * @package App\Models
 */
class LlxHoliday extends Model
{
	protected $table = 'llx_holiday';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_user' => 'int',
		'fk_user_create' => 'int',
		'fk_user_modif' => 'int',
		'fk_type' => 'int',
		'date_create' => 'datetime',
		'date_debut' => 'datetime',
		'date_fin' => 'datetime',
		'halfday' => 'int',
		'nb_open_day' => 'float',
		'statut' => 'int',
		'fk_validator' => 'int',
		'date_valid' => 'datetime',
		'fk_user_valid' => 'int',
		'date_approval' => 'datetime',
		'fk_user_approve' => 'int',
		'date_refuse' => 'datetime',
		'fk_user_refuse' => 'int',
		'date_cancel' => 'datetime',
		'fk_user_cancel' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'ref',
		'ref_ext',
		'entity',
		'fk_user',
		'fk_user_create',
		'fk_user_modif',
		'fk_type',
		'date_create',
		'description',
		'date_debut',
		'date_fin',
		'halfday',
		'nb_open_day',
		'statut',
		'fk_validator',
		'date_valid',
		'fk_user_valid',
		'date_approval',
		'fk_user_approve',
		'date_refuse',
		'fk_user_refuse',
		'date_cancel',
		'fk_user_cancel',
		'detail_refuse',
		'note_private',
		'note_public',
		'tms',
		'import_key',
		'extraparams'
	];
}
