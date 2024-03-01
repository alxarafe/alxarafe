<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxDefaultValue
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $type
 * @property int $user_id
 * @property string|null $page
 * @property string|null $param
 * @property string|null $value
 *
 * @package App\Models
 */
class LlxDefaultValue extends Model
{
	protected $table = 'llx_default_values';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'entity',
		'type',
		'user_id',
		'page',
		'param',
		'value'
	];
}
