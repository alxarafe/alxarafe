<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCPropalst
 *
 * @property int $id
 * @property string $code
 * @property string|null $label
 * @property int|null $sortorder
 * @property int $active
 *
 * @package App\Models
 */
class LlxCPropalst extends Model
{
	protected $table = 'llx_c_propalst';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'sortorder' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'sortorder',
		'active'
	];
}
