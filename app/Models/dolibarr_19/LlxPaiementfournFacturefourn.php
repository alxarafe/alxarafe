<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPaiementfournFacturefourn
 *
 * @property int $rowid
 * @property int|null $fk_paiementfourn
 * @property int|null $fk_facturefourn
 * @property float|null $amount
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_tx
 * @property float|null $multicurrency_amount
 *
 * @package App\Models
 */
class LlxPaiementfournFacturefourn extends Model
{
	protected $table = 'llx_paiementfourn_facturefourn';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_paiementfourn' => 'int',
		'fk_facturefourn' => 'int',
		'amount' => 'float',
		'multicurrency_tx' => 'float',
		'multicurrency_amount' => 'float'
	];

	protected $fillable = [
		'fk_paiementfourn',
		'fk_facturefourn',
		'amount',
		'multicurrency_code',
		'multicurrency_tx',
		'multicurrency_amount'
	];
}
