<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCStcommcontact
 *
 * @property int $id
 * @property string $code
 * @property string|null $libelle
 * @property string|null $picto
 * @property int $active
 *
 * @package App\Models
 */
class LlxCStcommcontact extends Model
{
	protected $table = 'llx_c_stcommcontact';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'libelle',
		'picto',
		'active'
	];
}
