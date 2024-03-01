<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBank
 *
 * @property int $rowid
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property Carbon|null $datev
 * @property Carbon|null $dateo
 * @property float $amount
 * @property float|null $amount_main_currency
 * @property string|null $label
 * @property int|null $fk_account
 * @property int|null $fk_user_author
 * @property int|null $fk_user_rappro
 * @property string|null $fk_type
 * @property string|null $num_releve
 * @property string|null $num_chq
 * @property string|null $numero_compte
 * @property int|null $rappro
 * @property string|null $note
 * @property int|null $fk_bordereau
 * @property int|null $position
 * @property string|null $banque
 * @property string|null $emetteur
 * @property string|null $author
 * @property int|null $origin_id
 * @property string|null $origin_type
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxBank extends Model
{
	protected $table = 'llx_bank';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datec' => 'datetime',
		'tms' => 'datetime',
		'datev' => 'datetime',
		'dateo' => 'datetime',
		'amount' => 'float',
		'amount_main_currency' => 'float',
		'fk_account' => 'int',
		'fk_user_author' => 'int',
		'fk_user_rappro' => 'int',
		'rappro' => 'int',
		'fk_bordereau' => 'int',
		'position' => 'int',
		'origin_id' => 'int'
	];

	protected $fillable = [
		'datec',
		'tms',
		'datev',
		'dateo',
		'amount',
		'amount_main_currency',
		'label',
		'fk_account',
		'fk_user_author',
		'fk_user_rappro',
		'fk_type',
		'num_releve',
		'num_chq',
		'numero_compte',
		'rappro',
		'note',
		'fk_bordereau',
		'position',
		'banque',
		'emetteur',
		'author',
		'origin_id',
		'origin_type',
		'import_key'
	];
}
