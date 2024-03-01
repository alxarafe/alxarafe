<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCAccountingCategory
 *
 * @property int $rowid
 * @property int $entity
 * @property string $code
 * @property string $label
 * @property string $range_account
 * @property int $sens
 * @property int $category_type
 * @property string $formula
 * @property int|null $position
 * @property int|null $fk_country
 * @property int|null $active
 *
 * @package App\Models
 */
class LlxCAccountingCategory extends Model
{
	protected $table = 'llx_c_accounting_category';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'sens' => 'int',
		'category_type' => 'int',
		'position' => 'int',
		'fk_country' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'entity',
		'code',
		'label',
		'range_account',
		'sens',
		'category_type',
		'formula',
		'position',
		'fk_country',
		'active'
	];
}
