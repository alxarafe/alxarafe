<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCEcotaxe
 *
 * @property int $rowid
 * @property string $code
 * @property string|null $label
 * @property float|null $price
 * @property string|null $organization
 * @property int $fk_pays
 * @property int $active
 *
 * @package App\Models
 */
class LlxCEcotaxe extends Model
{
	protected $table = 'llx_c_ecotaxe';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'price' => 'float',
		'fk_pays' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'price',
		'organization',
		'fk_pays',
		'active'
	];
}
