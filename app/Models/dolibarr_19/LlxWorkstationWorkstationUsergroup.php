<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxWorkstationWorkstationUsergroup
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property int|null $fk_usergroup
 * @property int|null $fk_workstation
 *
 * @package App\Models
 */
class LlxWorkstationWorkstationUsergroup extends Model
{
	protected $table = 'llx_workstation_workstation_usergroup';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'fk_usergroup' => 'int',
		'fk_workstation' => 'int'
	];

	protected $fillable = [
		'tms',
		'fk_usergroup',
		'fk_workstation'
	];
}
