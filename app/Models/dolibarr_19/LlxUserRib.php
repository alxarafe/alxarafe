<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUserRib
 *
 * @property int $rowid
 * @property int $fk_user
 * @property int $entity
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property string|null $label
 * @property string|null $bank
 * @property string|null $code_banque
 * @property string|null $code_guichet
 * @property string|null $number
 * @property string|null $cle_rib
 * @property string|null $bic
 * @property string|null $bic_intermediate
 * @property string|null $iban_prefix
 * @property string|null $domiciliation
 * @property string|null $proprio
 * @property string|null $owner_address
 * @property int|null $state_id
 * @property int|null $fk_country
 * @property string|null $currency_code
 *
 * @package App\Models
 */
class LlxUserRib extends Model
{
	protected $table = 'llx_user_rib';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_user' => 'int',
		'entity' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'state_id' => 'int',
		'fk_country' => 'int'
	];

	protected $fillable = [
		'fk_user',
		'entity',
		'datec',
		'tms',
		'label',
		'bank',
		'code_banque',
		'code_guichet',
		'number',
		'cle_rib',
		'bic',
		'bic_intermediate',
		'iban_prefix',
		'domiciliation',
		'proprio',
		'owner_address',
		'state_id',
		'fk_country',
		'currency_code'
	];
}
