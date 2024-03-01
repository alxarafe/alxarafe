<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSocietePrice
 *
 * @property int $rowid
 * @property int|null $fk_soc
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property int|null $fk_user_author
 * @property int|null $price_level
 *
 * @package App\Models
 */
class LlxSocietePrice extends Model
{
	protected $table = 'llx_societe_prices';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_soc' => 'int',
		'tms' => 'datetime',
		'datec' => 'datetime',
		'fk_user_author' => 'int',
		'price_level' => 'int'
	];

	protected $fillable = [
		'fk_soc',
		'tms',
		'datec',
		'fk_user_author',
		'price_level'
	];
}
