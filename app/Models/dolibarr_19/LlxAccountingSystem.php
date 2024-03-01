<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxAccountingSystem
 *
 * @property int $rowid
 * @property int|null $fk_country
 * @property string $pcg_version
 * @property string $label
 * @property int|null $active
 *
 * @property Collection|LlxAccountingAccount[] $llx_accounting_accounts
 *
 * @package App\Models
 */
class LlxAccountingSystem extends Model
{
	protected $table = 'llx_accounting_system';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_country' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'fk_country',
		'pcg_version',
		'label',
		'active'
	];

	public function llx_accounting_accounts()
	{
		return $this->hasMany(LlxAccountingAccount::class, 'fk_pcg_version', 'pcg_version');
	}
}
