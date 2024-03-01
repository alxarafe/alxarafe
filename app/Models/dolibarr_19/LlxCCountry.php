<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCCountry
 *
 * @property int $rowid
 * @property string $code
 * @property string|null $code_iso
 * @property string|null $numeric_code
 * @property string $label
 * @property int $eec
 * @property int $active
 * @property int $favorite
 *
 * @property Collection|LlxCRegion[] $llx_c_regions
 * @property Collection|LlxCZiptown[] $llx_c_ziptowns
 * @property Collection|LlxProduct[] $llx_products
 * @property Collection|LlxResource[] $llx_resources
 *
 * @package App\Models
 */
class LlxCCountry extends Model
{
	protected $table = 'llx_c_country';
	protected $primaryKey = 'rowid';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'rowid' => 'int',
		'eec' => 'int',
		'active' => 'int',
		'favorite' => 'int'
	];

	protected $fillable = [
		'code',
		'code_iso',
		'numeric_code',
		'label',
		'eec',
		'active',
		'favorite'
	];

	public function llx_c_regions()
	{
		return $this->hasMany(LlxCRegion::class, 'fk_pays');
	}

	public function llx_c_ziptowns()
	{
		return $this->hasMany(LlxCZiptown::class, 'fk_pays');
	}

	public function llx_products()
	{
		return $this->hasMany(LlxProduct::class, 'fk_country');
	}

	public function llx_resources()
	{
		return $this->hasMany(LlxResource::class, 'fk_country');
	}
}
