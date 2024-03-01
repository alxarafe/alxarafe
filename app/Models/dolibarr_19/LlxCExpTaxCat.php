<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCExpTaxCat
 *
 * @property int $rowid
 * @property string $label
 * @property int $entity
 * @property int $active
 *
 * @package App\Models
 */
class LlxCExpTaxCat extends Model
{
	protected $table = 'llx_c_exp_tax_cat';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'label',
		'entity',
		'active'
	];
}
