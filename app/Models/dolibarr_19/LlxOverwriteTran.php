<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxOverwriteTran
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $lang
 * @property string|null $transkey
 * @property string|null $transvalue
 *
 * @package App\Models
 */
class LlxOverwriteTran extends Model
{
	protected $table = 'llx_overwrite_trans';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int'
	];

	protected $fillable = [
		'entity',
		'lang',
		'transkey',
		'transvalue'
	];
}
