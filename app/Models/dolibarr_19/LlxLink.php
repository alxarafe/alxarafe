<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxLink
 *
 * @property int $rowid
 * @property int $entity
 * @property Carbon $datea
 * @property string $url
 * @property string $label
 * @property string $objecttype
 * @property int $objectid
 *
 * @package App\Models
 */
class LlxLink extends Model
{
	protected $table = 'llx_links';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'datea' => 'datetime',
		'objectid' => 'int'
	];

	protected $fillable = [
		'entity',
		'datea',
		'url',
		'label',
		'objecttype',
		'objectid'
	];
}
