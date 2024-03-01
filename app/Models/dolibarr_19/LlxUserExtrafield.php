<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUserExtrafield
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property int $fk_object
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxUserExtrafield extends Model
{
	protected $table = 'llx_user_extrafields';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'fk_object' => 'int'
	];

	protected $fillable = [
		'tms',
		'fk_object',
		'import_key'
	];
}
