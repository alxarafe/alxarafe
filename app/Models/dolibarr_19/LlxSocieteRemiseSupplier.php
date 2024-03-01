<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSocieteRemiseSupplier
 *
 * @property int $rowid
 * @property int $entity
 * @property int $fk_soc
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property int|null $fk_user_author
 * @property float $remise_supplier
 * @property string|null $note
 *
 * @package App\Models
 */
class LlxSocieteRemiseSupplier extends Model
{
	protected $table = 'llx_societe_remise_supplier';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_soc' => 'int',
		'tms' => 'datetime',
		'datec' => 'datetime',
		'fk_user_author' => 'int',
		'remise_supplier' => 'float'
	];

	protected $fillable = [
		'entity',
		'fk_soc',
		'tms',
		'datec',
		'fk_user_author',
		'remise_supplier',
		'note'
	];
}
