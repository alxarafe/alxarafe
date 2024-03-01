<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxWorkstationWorkstation
 *
 * @property int $rowid
 * @property string $ref
 * @property string|null $label
 * @property string|null $type
 * @property string|null $note_public
 * @property int|null $entity
 * @property string|null $note_private
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $import_key
 * @property int $status
 * @property int|null $nb_operators_required
 * @property float|null $thm_operator_estimated
 * @property float|null $thm_machine_estimated
 *
 * @property LlxUser $llx_user
 *
 * @package App\Models
 */
class LlxWorkstationWorkstation extends Model
{
	protected $table = 'llx_workstation_workstation';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'status' => 'int',
		'nb_operators_required' => 'int',
		'thm_operator_estimated' => 'float',
		'thm_machine_estimated' => 'float'
	];

	protected $fillable = [
		'ref',
		'label',
		'type',
		'note_public',
		'entity',
		'note_private',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'import_key',
		'status',
		'nb_operators_required',
		'thm_operator_estimated',
		'thm_machine_estimated'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}
}
