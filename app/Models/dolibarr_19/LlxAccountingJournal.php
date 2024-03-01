<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxAccountingJournal
 *
 * @property int $rowid
 * @property int $entity
 * @property string $code
 * @property string $label
 * @property int $nature
 * @property int|null $active
 *
 * @property Collection|LlxBankAccount[] $llx_bank_accounts
 *
 * @package App\Models
 */
class LlxAccountingJournal extends Model
{
	protected $table = 'llx_accounting_journal';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'nature' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'entity',
		'code',
		'label',
		'nature',
		'active'
	];

	public function llx_bank_accounts()
	{
		return $this->hasMany(LlxBankAccount::class, 'fk_accountancy_journal');
	}
}
