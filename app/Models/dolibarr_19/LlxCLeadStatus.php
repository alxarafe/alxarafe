<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCLeadStatus
 *
 * @property int $rowid
 * @property string|null $code
 * @property string|null $label
 * @property int|null $position
 * @property float|null $percent
 * @property int $active
 *
 * @package App\Models
 */
class LlxCLeadStatus extends Model
{
	protected $table = 'llx_c_lead_status';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'position' => 'int',
		'percent' => 'float',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'position',
		'percent',
		'active'
	];
}
