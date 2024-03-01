<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxAccountingFiscalyear
 *
 * @property int $rowid
 * @property string $label
 * @property Carbon|null $date_start
 * @property Carbon|null $date_end
 * @property int $statut
 * @property int $entity
 * @property Carbon $datec
 * @property Carbon|null $tms
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 *
 * @package App\Models
 */
class LlxAccountingFiscalyear extends Model
{
	protected $table = 'llx_accounting_fiscalyear';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_start' => 'datetime',
		'date_end' => 'datetime',
		'statut' => 'int',
		'entity' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'label',
		'date_start',
		'date_end',
		'statut',
		'entity',
		'datec',
		'tms',
		'fk_user_author',
		'fk_user_modif'
	];
}
