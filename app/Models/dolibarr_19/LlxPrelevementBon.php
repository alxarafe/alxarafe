<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPrelevementBon
 *
 * @property int $rowid
 * @property string|null $type
 * @property string|null $ref
 * @property int $entity
 * @property Carbon|null $datec
 * @property float|null $amount
 * @property int|null $statut
 * @property int|null $credite
 * @property string|null $note
 * @property Carbon|null $date_trans
 * @property int|null $method_trans
 * @property int|null $fk_user_trans
 * @property Carbon|null $date_credit
 * @property int|null $fk_user_credit
 * @property int|null $fk_bank_account
 *
 * @property Collection|LlxPrelevementLigne[] $llx_prelevement_lignes
 *
 * @package App\Models
 */
class LlxPrelevementBon extends Model
{
	protected $table = 'llx_prelevement_bons';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'datec' => 'datetime',
		'amount' => 'float',
		'statut' => 'int',
		'credite' => 'int',
		'date_trans' => 'datetime',
		'method_trans' => 'int',
		'fk_user_trans' => 'int',
		'date_credit' => 'datetime',
		'fk_user_credit' => 'int',
		'fk_bank_account' => 'int'
	];

	protected $fillable = [
		'type',
		'ref',
		'entity',
		'datec',
		'amount',
		'statut',
		'credite',
		'note',
		'date_trans',
		'method_trans',
		'fk_user_trans',
		'date_credit',
		'fk_user_credit',
		'fk_bank_account'
	];

	public function llx_prelevement_lignes()
	{
		return $this->hasMany(LlxPrelevementLigne::class, 'fk_prelevement_bons');
	}
}
