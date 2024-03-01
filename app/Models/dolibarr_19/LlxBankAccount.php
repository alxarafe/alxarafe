<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBankAccount
 *
 * @property int $rowid
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property string $ref
 * @property string $label
 * @property int $entity
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property string|null $bank
 * @property string|null $code_banque
 * @property string|null $code_guichet
 * @property string|null $number
 * @property string|null $cle_rib
 * @property string|null $bic
 * @property string|null $bic_intermediate
 * @property string|null $iban_prefix
 * @property string|null $country_iban
 * @property string|null $cle_iban
 * @property string|null $domiciliation
 * @property int|null $pti_in_ctti
 * @property int|null $state_id
 * @property int $fk_pays
 * @property string|null $proprio
 * @property string|null $owner_address
 * @property string|null $owner_zip
 * @property string|null $owner_town
 * @property int|null $owner_country_id
 * @property int $courant
 * @property int $clos
 * @property int|null $rappro
 * @property string|null $url
 * @property string|null $account_number
 * @property int|null $fk_accountancy_journal
 * @property string $currency_code
 * @property int|null $min_allowed
 * @property int|null $min_desired
 * @property string|null $comment
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $import_key
 * @property string|null $extraparams
 * @property string|null $ics
 * @property string|null $ics_transfer
 *
 * @property LlxAccountingJournal|null $llx_accounting_journal
 * @property Collection|LlxCategorieAccount[] $llx_categorie_accounts
 *
 * @package App\Models
 */
class LlxBankAccount extends Model
{
	protected $table = 'llx_bank_account';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datec' => 'datetime',
		'tms' => 'datetime',
		'entity' => 'int',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'pti_in_ctti' => 'int',
		'state_id' => 'int',
		'fk_pays' => 'int',
		'owner_country_id' => 'int',
		'courant' => 'int',
		'clos' => 'int',
		'rappro' => 'int',
		'fk_accountancy_journal' => 'int',
		'min_allowed' => 'int',
		'min_desired' => 'int'
	];

	protected $fillable = [
		'datec',
		'tms',
		'ref',
		'label',
		'entity',
		'fk_user_author',
		'fk_user_modif',
		'bank',
		'code_banque',
		'code_guichet',
		'number',
		'cle_rib',
		'bic',
		'bic_intermediate',
		'iban_prefix',
		'country_iban',
		'cle_iban',
		'domiciliation',
		'pti_in_ctti',
		'state_id',
		'fk_pays',
		'proprio',
		'owner_address',
		'owner_zip',
		'owner_town',
		'owner_country_id',
		'courant',
		'clos',
		'rappro',
		'url',
		'account_number',
		'fk_accountancy_journal',
		'currency_code',
		'min_allowed',
		'min_desired',
		'comment',
		'note_public',
		'model_pdf',
		'import_key',
		'extraparams',
		'ics',
		'ics_transfer'
	];

	public function llx_accounting_journal()
	{
		return $this->belongsTo(LlxAccountingJournal::class, 'fk_accountancy_journal');
	}

	public function llx_categorie_accounts()
	{
		return $this->hasMany(LlxCategorieAccount::class, 'fk_account');
	}
}
