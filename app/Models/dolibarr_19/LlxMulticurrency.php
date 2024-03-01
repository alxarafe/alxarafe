<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxMulticurrency
 *
 * @property int $rowid
 * @property Carbon|null $date_create
 * @property string|null $code
 * @property string|null $name
 * @property int|null $entity
 * @property int|null $fk_user
 *
 * @package App\Models
 */
class LlxMulticurrency extends Model
{
	protected $table = 'llx_multicurrency';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_create' => 'datetime',
		'entity' => 'int',
		'fk_user' => 'int'
	];

	protected $fillable = [
		'date_create',
		'code',
		'name',
		'entity',
		'fk_user'
	];
}
