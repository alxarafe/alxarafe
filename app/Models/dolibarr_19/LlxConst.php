<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxConst
 *
 * @property int $rowid
 * @property string $name
 * @property int $entity
 * @property string $value
 * @property string|null $type
 * @property int $visible
 * @property string|null $note
 * @property Carbon|null $tms
 *
 * @package App\Models
 */
class LlxConst extends Model
{
	protected $table = 'llx_const';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'visible' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'name',
		'entity',
		'value',
		'type',
		'visible',
		'note',
		'tms'
	];
}
