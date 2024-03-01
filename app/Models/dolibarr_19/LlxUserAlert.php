<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUserAlert
 *
 * @property int $rowid
 * @property int|null $type
 * @property int|null $fk_contact
 * @property int|null $fk_user
 *
 * @package App\Models
 */
class LlxUserAlert extends Model
{
	protected $table = 'llx_user_alert';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'type' => 'int',
		'fk_contact' => 'int',
		'fk_user' => 'int'
	];

	protected $fillable = [
		'type',
		'fk_contact',
		'fk_user'
	];
}
