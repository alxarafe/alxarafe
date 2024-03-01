<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxNotify
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property Carbon|null $daten
 * @property int $fk_action
 * @property int|null $fk_soc
 * @property int|null $fk_contact
 * @property int|null $fk_user
 * @property string|null $type
 * @property string|null $type_target
 * @property string $objet_type
 * @property int $objet_id
 * @property string|null $email
 *
 * @package App\Models
 */
class LlxNotify extends Model
{
	protected $table = 'llx_notify';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'daten' => 'datetime',
		'fk_action' => 'int',
		'fk_soc' => 'int',
		'fk_contact' => 'int',
		'fk_user' => 'int',
		'objet_id' => 'int'
	];

	protected $fillable = [
		'tms',
		'daten',
		'fk_action',
		'fk_soc',
		'fk_contact',
		'fk_user',
		'type',
		'type_target',
		'objet_type',
		'objet_id',
		'email'
	];
}
