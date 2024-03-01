<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxOauthState
 *
 * @property int $rowid
 * @property string|null $service
 * @property string|null $state
 * @property int|null $fk_user
 * @property int|null $fk_adherent
 * @property int|null $entity
 *
 * @package App\Models
 */
class LlxOauthState extends Model
{
	protected $table = 'llx_oauth_state';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_user' => 'int',
		'fk_adherent' => 'int',
		'entity' => 'int'
	];

	protected $fillable = [
		'service',
		'state',
		'fk_user',
		'fk_adherent',
		'entity'
	];
}
