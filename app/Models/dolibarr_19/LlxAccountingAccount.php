<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxAccountingAccount
 *
 * @property int $rowid
 * @property int $entity
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property string $fk_pcg_version
 * @property string $pcg_type
 * @property string $account_number
 * @property int|null $account_parent
 * @property string $label
 * @property string|null $labelshort
 * @property int|null $fk_accounting_category
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int $active
 * @property int $reconcilable
 * @property string|null $import_key
 * @property string|null $extraparams
 *
 * @property LlxAccountingSystem $llx_accounting_system
 *
 * @package App\Models
 */
class LlxAccountingAccount extends Model
{
	protected $table = 'llx_accounting_account';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'account_parent' => 'int',
		'fk_accounting_category' => 'int',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'active' => 'int',
		'reconcilable' => 'int'
	];

	protected $fillable = [
		'entity',
		'datec',
		'tms',
		'fk_pcg_version',
		'pcg_type',
		'account_number',
		'account_parent',
		'label',
		'labelshort',
		'fk_accounting_category',
		'fk_user_author',
		'fk_user_modif',
		'active',
		'reconcilable',
		'import_key',
		'extraparams'
	];

	public function llx_accounting_system()
	{
		return $this->belongsTo(LlxAccountingSystem::class, 'fk_pcg_version', 'pcg_version');
	}
}
