<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxNotifyDefObject
 *
 * @property int $id
 * @property int $entity
 * @property string|null $objet_type
 * @property int $objet_id
 * @property string|null $type_notif
 * @property Carbon|null $date_notif
 * @property int|null $user_id
 * @property string|null $moreparam
 *
 * @package App\Models
 */
class LlxNotifyDefObject extends Model
{
	protected $table = 'llx_notify_def_object';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'objet_id' => 'int',
		'date_notif' => 'datetime',
		'user_id' => 'int'
	];

	protected $fillable = [
		'entity',
		'objet_type',
		'objet_id',
		'type_notif',
		'date_notif',
		'user_id',
		'moreparam'
	];
}
