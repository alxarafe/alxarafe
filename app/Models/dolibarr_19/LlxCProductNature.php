<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCProductNature
 *
 * @property int $rowid
 * @property int $code
 * @property string|null $label
 * @property int $active
 *
 * @property Collection|LlxProduct[] $llx_products
 *
 * @package App\Models
 */
class LlxCProductNature extends Model
{
	protected $table = 'llx_c_product_nature';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'code' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'active'
	];

	public function llx_products()
	{
		return $this->hasMany(LlxProduct::class, 'finished', 'code');
	}
}
