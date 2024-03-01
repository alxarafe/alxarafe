<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPaiement
 *
 * @property int $rowid
 * @property string|null $ref
 * @property string|null $ref_ext
 * @property int $entity
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property Carbon|null $datep
 * @property float|null $amount
 * @property float|null $multicurrency_amount
 * @property int $fk_paiement
 * @property string|null $num_paiement
 * @property string|null $note
 * @property string|null $ext_payment_id
 * @property string|null $ext_payment_site
 * @property int $fk_bank
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int $statut
 * @property int $fk_export_compta
 * @property float|null $pos_change
 *
 * @property Collection|LlxPaiementFacture[] $llx_paiement_factures
 *
 * @package App\Models
 */
class LlxPaiement extends Model
{
	protected $table = 'llx_paiement';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'datep' => 'datetime',
		'amount' => 'float',
		'multicurrency_amount' => 'float',
		'fk_paiement' => 'int',
		'fk_bank' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'statut' => 'int',
		'fk_export_compta' => 'int',
		'pos_change' => 'float'
	];

	protected $fillable = [
		'ref',
		'ref_ext',
		'entity',
		'datec',
		'tms',
		'datep',
		'amount',
		'multicurrency_amount',
		'fk_paiement',
		'num_paiement',
		'note',
		'ext_payment_id',
		'ext_payment_site',
		'fk_bank',
		'fk_user_creat',
		'fk_user_modif',
		'statut',
		'fk_export_compta',
		'pos_change'
	];

	public function llx_paiement_factures()
	{
		return $this->hasMany(LlxPaiementFacture::class, 'fk_paiement');
	}
}
