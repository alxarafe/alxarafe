<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxWorkstationWorkstationResource
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property int|null $fk_resource
 * @property int|null $fk_workstation
 *
 * @package App\Models
 */
class LlxWorkstationWorkstationResource extends Model
{
	protected $table = 'llx_workstation_workstation_resource';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'fk_resource' => 'int',
		'fk_workstation' => 'int'
	];

	protected $fillable = [
		'tms',
		'fk_resource',
		'fk_workstation'
	];
}
