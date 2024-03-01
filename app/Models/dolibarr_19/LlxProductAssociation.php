<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductAssociation
 *
 * @property int $rowid
 * @property int $fk_product_pere
 * @property int $fk_product_fils
 * @property float|null $qty
 * @property int|null $incdec
 * @property int|null $rang
 *
 * @package App\Models
 */
class LlxProductAssociation extends Model
{
	protected $table = 'llx_product_association';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_product_pere' => 'int',
		'fk_product_fils' => 'int',
		'qty' => 'float',
		'incdec' => 'int',
		'rang' => 'int'
	];

	protected $fillable = [
		'fk_product_pere',
		'fk_product_fils',
		'qty',
		'incdec',
		'rang'
	];
}
