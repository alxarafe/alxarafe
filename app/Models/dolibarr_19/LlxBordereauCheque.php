<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBordereauCheque
 *
 * @property int $rowid
 * @property string $ref
 * @property string|null $label
 * @property string|null $ref_ext
 * @property string|null $type
 * @property Carbon $datec
 * @property Carbon|null $date_bordereau
 * @property float $amount
 * @property int $nbcheque
 * @property int|null $fk_bank_account
 * @property int|null $fk_user_author
 * @property int $statut
 * @property Carbon|null $tms
 * @property string|null $note
 * @property int $entity
 *
 * @package App\Models
 */
class LlxBordereauCheque extends Model
{
	protected $table = 'llx_bordereau_cheque';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datec' => 'datetime',
		'date_bordereau' => 'datetime',
		'amount' => 'float',
		'nbcheque' => 'int',
		'fk_bank_account' => 'int',
		'fk_user_author' => 'int',
		'statut' => 'int',
		'tms' => 'datetime',
		'entity' => 'int'
	];

	protected $fillable = [
		'ref',
		'label',
		'ref_ext',
		'type',
		'datec',
		'date_bordereau',
		'amount',
		'nbcheque',
		'fk_bank_account',
		'fk_user_author',
		'statut',
		'tms',
		'note',
		'entity'
	];
}
