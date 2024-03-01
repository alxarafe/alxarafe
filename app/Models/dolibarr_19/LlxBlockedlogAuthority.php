<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBlockedlogAuthority
 *
 * @property int $rowid
 * @property string $blockchain
 * @property string $signature
 * @property Carbon|null $tms
 *
 * @package App\Models
 */
class LlxBlockedlogAuthority extends Model
{
	protected $table = 'llx_blockedlog_authority';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime'
	];

	protected $fillable = [
		'blockchain',
		'signature',
		'tms'
	];
}
