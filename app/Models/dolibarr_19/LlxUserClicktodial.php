<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUserClicktodial
 *
 * @property int $fk_user
 * @property string|null $url
 * @property string|null $login
 * @property string|null $pass
 * @property string|null $poste
 *
 * @package App\Models
 */
class LlxUserClicktodial extends Model
{
	protected $table = 'llx_user_clicktodial';
	protected $primaryKey = 'fk_user';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_user' => 'int'
	];

	protected $fillable = [
		'url',
		'login',
		'pass',
		'poste'
	];
}
