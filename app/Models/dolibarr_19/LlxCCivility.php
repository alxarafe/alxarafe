<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCCivility
 *
 * @property int $rowid
 * @property string $code
 * @property string|null $label
 * @property int $active
 * @property string|null $module
 *
 * @package App\Models
 */
class LlxCCivility extends Model
{
	protected $table = 'llx_c_civility';
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
