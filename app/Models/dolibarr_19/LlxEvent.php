<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxEvent
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property string $type
 * @property int $entity
 * @property string|null $prefix_session
 * @property Carbon|null $dateevent
 * @property int|null $fk_user
 * @property string $description
 * @property string $ip
 * @property string|null $user_agent
 * @property int|null $fk_object
 * @property string|null $authentication_method
 * @property int|null $fk_oauth_token
 *
 * @package App\Models
 */
class LlxEvent extends Model
{
	protected $table = 'llx_events';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'entity' => 'int',
		'dateevent' => 'datetime',
		'fk_user' => 'int',
		'fk_object' => 'int',
		'fk_oauth_token' => 'int'
	];

	protected $hidden = [
		'fk_oauth_token'
	];

	protected $fillable = [
		'tms',
		'type',
		'entity',
		'prefix_session',
		'dateevent',
		'fk_user',
		'description',
		'ip',
		'user_agent',
		'fk_object',
		'authentication_method',
		'fk_oauth_token'
	];
}
