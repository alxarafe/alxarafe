<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCProspectcontactlevel
 *
 * @property string $code
 * @property string|null $label
 * @property int|null $sortorder
 * @property int $active
 * @property string|null $module
 *
 * @package App\Models
 */
class LlxCProspectcontactlevel extends Model
{
	protected $table = 'llx_c_prospectcontactlevel';
	protected $primaryKey = 'code';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'sortorder' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'label',
		'sortorder',
		'active',
		'module'
	];
}
