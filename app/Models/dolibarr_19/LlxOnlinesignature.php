<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxOnlinesignature
 *
 * @property int $rowid
 * @property int $entity
 * @property string $object_type
 * @property int $object_id
 * @property Carbon $datec
 * @property Carbon|null $tms
 * @property string $name
 * @property string|null $ip
 * @property string|null $pathoffile
 *
 * @package App\Models
 */
class LlxOnlinesignature extends Model
{
	protected $table = 'llx_onlinesignature';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'object_id' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'object_type',
		'object_id',
		'datec',
		'tms',
		'name',
		'ip',
		'pathoffile'
	];
}
