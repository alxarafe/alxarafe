<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPaiementFacture
 *
 * @property int $rowid
 * @property int|null $fk_paiement
 * @property int|null $fk_facture
 * @property float|null $amount
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_tx
 * @property float|null $multicurrency_amount
 *
 * @property LlxFacture|null $llx_facture
 * @property LlxPaiement|null $llx_paiement
 *
 * @package App\Models
 */
class LlxPaiementFacture extends Model
{
	protected $table = 'llx_paiement_facture';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_paiement' => 'int',
		'fk_facture' => 'int',
		'amount' => 'float',
		'multicurrency_tx' => 'float',
		'multicurrency_amount' => 'float'
	];

	protected $fillable = [
		'fk_paiement',
		'fk_facture',
		'amount',
		'multicurrency_code',
		'multicurrency_tx',
		'multicurrency_amount'
	];

	public function llx_facture()
	{
		return $this->belongsTo(LlxFacture::class, 'fk_facture');
	}

	public function llx_paiement()
	{
		return $this->belongsTo(LlxPaiement::class, 'fk_paiement');
	}
}
