<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxMulticurrencyRate
 *
 * @property int $rowid
 * @property Carbon|null $date_sync
 * @property float $rate
 * @property float|null $rate_indirect
 * @property int $fk_multicurrency
 * @property int|null $entity
 *
 * @package App\Models
 */
class LlxMulticurrencyRate extends Model
{
	protected $table = 'llx_multicurrency_rate';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_sync' => 'datetime',
		'rate' => 'float',
		'rate_indirect' => 'float',
		'fk_multicurrency' => 'int',
		'entity' => 'int'
	];

	protected $fillable = [
		'date_sync',
		'rate',
		'rate_indirect',
		'fk_multicurrency',
		'entity'
	];
}
