<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxNotifyDef
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property int $fk_action
 * @property int|null $fk_soc
 * @property int|null $fk_contact
 * @property int|null $fk_user
 * @property string|null $email
 * @property float|null $threshold
 * @property string|null $context
 * @property string|null $type
 *
 * @package App\Models
 */
class LlxNotifyDef extends Model
{
	protected $table = 'llx_notify_def';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'datec' => 'datetime',
		'fk_action' => 'int',
		'fk_soc' => 'int',
		'fk_contact' => 'int',
		'fk_user' => 'int',
		'threshold' => 'float'
	];

	protected $fillable = [
		'tms',
		'datec',
		'fk_action',
		'fk_soc',
		'fk_contact',
		'fk_user',
		'email',
		'threshold',
		'context',
		'type'
	];
}
