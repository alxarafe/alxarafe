<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxElementResource
 *
 * @property int $rowid
 * @property int|null $element_id
 * @property string|null $element_type
 * @property int|null $resource_id
 * @property string|null $resource_type
 * @property int|null $busy
 * @property int|null $mandatory
 * @property float|null $duree
 * @property int|null $fk_user_create
 * @property Carbon|null $tms
 *
 * @package App\Models
 */
class LlxElementResource extends Model
{
	protected $table = 'llx_element_resources';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'element_id' => 'int',
		'resource_id' => 'int',
		'busy' => 'int',
		'mandatory' => 'int',
		'duree' => 'float',
		'fk_user_create' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'element_id',
		'element_type',
		'resource_id',
		'resource_type',
		'busy',
		'mandatory',
		'duree',
		'fk_user_create',
		'tms'
	];
}
