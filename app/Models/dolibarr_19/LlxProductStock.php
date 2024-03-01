<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductStock
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property int $fk_product
 * @property int $fk_entrepot
 * @property float|null $reel
 * @property string|null $import_key
 *
 * @property LlxEntrepot $llx_entrepot
 * @property LlxProduct $llx_product
 * @property Collection|LlxProductBatch[] $llx_product_batches
 *
 * @package App\Models
 */
class LlxProductStock extends Model
{
	protected $table = 'llx_product_stock';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'fk_product' => 'int',
		'fk_entrepot' => 'int',
		'reel' => 'float'
	];

	protected $fillable = [
		'tms',
		'fk_product',
		'fk_entrepot',
		'reel',
		'import_key'
	];

	public function llx_entrepot()
	{
		return $this->belongsTo(LlxEntrepot::class, 'fk_entrepot');
	}

	public function llx_product()
	{
		return $this->belongsTo(LlxProduct::class, 'fk_product');
	}

	public function llx_product_batches()
	{
		return $this->hasMany(LlxProductBatch::class, 'fk_product_stock');
	}
}
