<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxAccountingGroupsAccount
 *
 * @property int $rowid
 * @property int $fk_accounting_account
 * @property int $fk_c_accounting_category
 *
 * @package App\Models
 */
class LlxAccountingGroupsAccount extends Model
{
	protected $table = 'llx_accounting_groups_account';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_accounting_account' => 'int',
		'fk_c_accounting_category' => 'int'
	];

	protected $fillable = [
		'fk_accounting_account',
		'fk_c_accounting_category'
	];
}
