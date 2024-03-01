<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxActioncommReminder
 *
 * @property int $rowid
 * @property Carbon $dateremind
 * @property string $typeremind
 * @property int $fk_user
 * @property int $offsetvalue
 * @property string $offsetunit
 * @property int $status
 * @property string|null $lasterror
 * @property int $entity
 * @property int $fk_actioncomm
 * @property int|null $fk_email_template
 *
 * @package App\Models
 */
class LlxActioncommReminder extends Model
{
	protected $table = 'llx_actioncomm_reminder';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'dateremind' => 'datetime',
		'fk_user' => 'int',
		'offsetvalue' => 'int',
		'status' => 'int',
		'entity' => 'int',
		'fk_actioncomm' => 'int',
		'fk_email_template' => 'int'
	];

	protected $fillable = [
		'dateremind',
		'typeremind',
		'fk_user',
		'offsetvalue',
		'offsetunit',
		'status',
		'lasterror',
		'entity',
		'fk_actioncomm',
		'fk_email_template'
	];
}
