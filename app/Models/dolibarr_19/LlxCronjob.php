<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCronjob
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property string $jobtype
 * @property string $label
 * @property string|null $command
 * @property string|null $classesname
 * @property string|null $objectname
 * @property string|null $methodename
 * @property string|null $params
 * @property string|null $md5params
 * @property string|null $module_name
 * @property int|null $priority
 * @property Carbon|null $datelastrun
 * @property Carbon|null $datenextrun
 * @property Carbon|null $datestart
 * @property Carbon|null $dateend
 * @property Carbon|null $datelastresult
 * @property string|null $lastresult
 * @property string|null $lastoutput
 * @property string $unitfrequency
 * @property int $frequency
 * @property int $maxrun
 * @property int|null $nbrun
 * @property int|null $autodelete
 * @property int $status
 * @property int $processing
 * @property int|null $pid
 * @property string|null $test
 * @property int|null $fk_user_author
 * @property int|null $fk_user_mod
 * @property int|null $fk_mailing
 * @property string|null $note
 * @property string|null $libname
 * @property string|null $email_alert
 * @property int|null $entity
 *
 * @package App\Models
 */
class LlxCronjob extends Model
{
	protected $table = 'llx_cronjob';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'datec' => 'datetime',
		'priority' => 'int',
		'datelastrun' => 'datetime',
		'datenextrun' => 'datetime',
		'datestart' => 'datetime',
		'dateend' => 'datetime',
		'datelastresult' => 'datetime',
		'frequency' => 'int',
		'maxrun' => 'int',
		'nbrun' => 'int',
		'autodelete' => 'int',
		'status' => 'int',
		'processing' => 'int',
		'pid' => 'int',
		'fk_user_author' => 'int',
		'fk_user_mod' => 'int',
		'fk_mailing' => 'int',
		'entity' => 'int'
	];

	protected $fillable = [
		'tms',
		'datec',
		'jobtype',
		'label',
		'command',
		'classesname',
		'objectname',
		'methodename',
		'params',
		'md5params',
		'module_name',
		'priority',
		'datelastrun',
		'datenextrun',
		'datestart',
		'dateend',
		'datelastresult',
		'lastresult',
		'lastoutput',
		'unitfrequency',
		'frequency',
		'maxrun',
		'nbrun',
		'autodelete',
		'status',
		'processing',
		'pid',
		'test',
		'fk_user_author',
		'fk_user_mod',
		'fk_mailing',
		'note',
		'libname',
		'email_alert',
		'entity'
	];
}
