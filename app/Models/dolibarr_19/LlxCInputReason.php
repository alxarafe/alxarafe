<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCInputReason
 *
 * @property int $rowid
 * @property string|null $code
 * @property string|null $label
 * @property int $active
 * @property string|null $module
 *
 * @package App\Models
 */
class LlxCInputReason extends Model
{
	protected $table = 'llx_c_input_reason';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'active',
		'module'
	];
}
