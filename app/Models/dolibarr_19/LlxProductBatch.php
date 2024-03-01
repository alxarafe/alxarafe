<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductBatch
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property int $fk_product_stock
 * @property Carbon|null $eatby
 * @property Carbon|null $sellby
 * @property string $batch
 * @property float $qty
 * @property string|null $import_key
 *
 * @property LlxProductStock $llx_product_stock
 *
 * @package App\Models
 */
class LlxProductBatch extends Model
{
	protected $table = 'llx_product_batch';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'fk_product_stock' => 'int',
		'eatby' => 'datetime',
		'sellby' => 'datetime',
		'qty' => 'float'
	];

	protected $fillable = [
		'tms',
		'fk_product_stock',
		'eatby',
		'sellby',
		'batch',
		'qty',
		'import_key'
	];

	public function llx_product_stock()
	{
		return $this->belongsTo(LlxProductStock::class, 'fk_product_stock');
	}
}
