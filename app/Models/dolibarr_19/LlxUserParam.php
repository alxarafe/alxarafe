<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUserParam
 *
 * @property int $fk_user
 * @property int $entity
 * @property string $param
 * @property string $value
 *
 * @package App\Models
 */
class LlxUserParam extends Model
{
	protected $table = 'llx_user_param';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_user' => 'int',
		'entity' => 'int'
	];

	protected $fillable = [
		'value'
	];
}
