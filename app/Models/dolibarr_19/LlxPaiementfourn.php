<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPaiementfourn
 *
 * @property int $rowid
 * @property string|null $ref
 * @property int|null $entity
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property Carbon|null $datep
 * @property float|null $amount
 * @property float|null $multicurrency_amount
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int $fk_paiement
 * @property string|null $num_paiement
 * @property string|null $note
 * @property int $fk_bank
 * @property int $statut
 * @property string|null $model_pdf
 *
 * @package App\Models
 */
class LlxPaiementfourn extends Model
{
	protected $table = 'llx_paiementfourn';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'tms' => 'datetime',
		'datec' => 'datetime',
		'datep' => 'datetime',
		'amount' => 'float',
		'multicurrency_amount' => 'float',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_paiement' => 'int',
		'fk_bank' => 'int',
		'statut' => 'int'
	];

	protected $fillable = [
		'ref',
		'entity',
		'tms',
		'datec',
		'datep',
		'amount',
		'multicurrency_amount',
		'fk_user_author',
		'fk_user_modif',
		'fk_paiement',
		'num_paiement',
		'note',
		'fk_bank',
		'statut',
		'model_pdf'
	];
}
