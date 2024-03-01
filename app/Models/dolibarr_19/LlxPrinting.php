<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPrinting
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property string $printer_name
 * @property string $printer_location
 * @property string $printer_id
 * @property int $copy
 * @property string $module
 * @property string $driver
 * @property int|null $userid
 *
 * @package App\Models
 */
class LlxPrinting extends Model
{
	protected $table = 'llx_printing';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'datec' => 'datetime',
		'copy' => 'int',
		'userid' => 'int'
	];

	protected $fillable = [
		'tms',
		'datec',
		'printer_name',
		'printer_location',
		'printer_id',
		'copy',
		'module',
		'driver',
		'userid'
	];
}
