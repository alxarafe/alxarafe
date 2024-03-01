<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxExpeditiondetBatch
 *
 * @property int $rowid
 * @property int $fk_expeditiondet
 * @property Carbon|null $eatby
 * @property Carbon|null $sellby
 * @property string|null $batch
 * @property float $qty
 * @property int $fk_origin_stock
 * @property int|null $fk_warehouse
 *
 * @property LlxExpeditiondet $llx_expeditiondet
 *
 * @package App\Models
 */
class LlxExpeditiondetBatch extends Model
{
	protected $table = 'llx_expeditiondet_batch';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_expeditiondet' => 'int',
		'eatby' => 'datetime',
		'sellby' => 'datetime',
		'qty' => 'float',
		'fk_origin_stock' => 'int',
		'fk_warehouse' => 'int'
	];

	protected $fillable = [
		'fk_expeditiondet',
		'eatby',
		'sellby',
		'batch',
		'qty',
		'fk_origin_stock',
		'fk_warehouse'
	];

	public function llx_expeditiondet()
	{
		return $this->belongsTo(LlxExpeditiondet::class, 'fk_expeditiondet');
	}
}
