<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCInputMethod
 *
 * @property int $rowid
 * @property string|null $code
 * @property string|null $libelle
 * @property int $active
 * @property string|null $module
 *
 * @package App\Models
 */
class LlxCInputMethod extends Model
{
	protected $table = 'llx_c_input_method';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'libelle',
		'active',
		'module'
	];
}
