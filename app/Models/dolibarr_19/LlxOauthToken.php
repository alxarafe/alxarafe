<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxOauthToken
 *
 * @property int $rowid
 * @property string|null $service
 * @property string|null $token
 * @property string|null $tokenstring
 * @property string|null $state
 * @property int|null $fk_soc
 * @property int|null $fk_user
 * @property int|null $fk_adherent
 * @property string|null $restricted_ips
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int|null $entity
 *
 * @package App\Models
 */
class LlxOauthToken extends Model
{
	protected $table = 'llx_oauth_token';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_soc' => 'int',
		'fk_user' => 'int',
		'fk_adherent' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'entity' => 'int'
	];

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'service',
		'token',
		'tokenstring',
		'state',
		'fk_soc',
		'fk_user',
		'fk_adherent',
		'restricted_ips',
		'datec',
		'tms',
		'entity'
	];
}
