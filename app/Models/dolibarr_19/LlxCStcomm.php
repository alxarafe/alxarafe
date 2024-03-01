<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCStcomm
 *
 * @property int $id
 * @property string $code
 * @property string|null $libelle
 * @property string|null $picto
 * @property int|null $sortorder
 * @property int $active
 *
 * @package App\Models
 */
class LlxCStcomm extends Model
{
	protected $table = 'llx_c_stcomm';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'sortorder' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'libelle',
		'picto',
		'sortorder',
		'active'
	];
}
