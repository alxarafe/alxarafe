<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPosCashFence
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $ref
 * @property string|null $label
 * @property float|null $opening
 * @property float|null $cash
 * @property float|null $card
 * @property float|null $cheque
 * @property int|null $status
 * @property Carbon $date_creation
 * @property Carbon|null $date_valid
 * @property int|null $day_close
 * @property int|null $month_close
 * @property int|null $year_close
 * @property string|null $posmodule
 * @property string|null $posnumber
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_valid
 * @property Carbon|null $tms
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxPosCashFence extends Model
{
	protected $table = 'llx_pos_cash_fence';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'opening' => 'float',
		'cash' => 'float',
		'card' => 'float',
		'cheque' => 'float',
		'status' => 'int',
		'date_creation' => 'datetime',
		'date_valid' => 'datetime',
		'day_close' => 'int',
		'month_close' => 'int',
		'year_close' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_valid' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'ref',
		'label',
		'opening',
		'cash',
		'card',
		'cheque',
		'status',
		'date_creation',
		'date_valid',
		'day_close',
		'month_close',
		'year_close',
		'posmodule',
		'posnumber',
		'fk_user_creat',
		'fk_user_valid',
		'tms',
		'import_key'
	];
}
