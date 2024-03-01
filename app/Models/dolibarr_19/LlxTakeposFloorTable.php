<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxTakeposFloorTable
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $label
 * @property float|null $leftpos
 * @property float|null $toppos
 * @property int|null $floor
 *
 * @package App\Models
 */
class LlxTakeposFloorTable extends Model
{
	protected $table = 'llx_takepos_floor_tables';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'leftpos' => 'float',
		'toppos' => 'float',
		'floor' => 'int'
	];

	protected $fillable = [
		'entity',
		'label',
		'leftpos',
		'toppos',
		'floor'
	];
}
