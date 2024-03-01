<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBlockedlog
 *
 * @property int $rowid
 * @property int $entity
 * @property Carbon|null $date_creation
 * @property Carbon|null $tms
 * @property string|null $action
 * @property float $amounts
 * @property string|null $element
 * @property int|null $fk_user
 * @property string|null $user_fullname
 * @property int|null $fk_object
 * @property string|null $ref_object
 * @property Carbon|null $date_object
 * @property string $signature
 * @property string $signature_line
 * @property string|null $object_data
 * @property string|null $object_version
 * @property int|null $certified
 *
 * @package App\Models
 */
class LlxBlockedlog extends Model
{
	protected $table = 'llx_blockedlog';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'amounts' => 'float',
		'fk_user' => 'int',
		'fk_object' => 'int',
		'date_object' => 'datetime',
		'certified' => 'int'
	];

	protected $fillable = [
		'entity',
		'date_creation',
		'tms',
		'action',
		'amounts',
		'element',
		'fk_user',
		'user_fullname',
		'fk_object',
		'ref_object',
		'date_object',
		'signature',
		'signature_line',
		'object_data',
		'object_version',
		'certified'
	];
}
