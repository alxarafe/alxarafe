<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxStockMouvement
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property Carbon|null $datem
 * @property int $fk_product
 * @property string|null $batch
 * @property Carbon|null $eatby
 * @property Carbon|null $sellby
 * @property int $fk_entrepot
 * @property float|null $value
 * @property float|null $price
 * @property int|null $type_mouvement
 * @property int|null $fk_user_author
 * @property string|null $label
 * @property string|null $inventorycode
 * @property int|null $fk_project
 * @property int|null $fk_origin
 * @property string|null $origintype
 * @property string|null $model_pdf
 * @property int $fk_projet
 *
 * @property Collection|LlxMrpProduction[] $llx_mrp_productions
 *
 * @package App\Models
 */
class LlxStockMouvement extends Model
{
	protected $table = 'llx_stock_mouvement';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'datem' => 'datetime',
		'fk_product' => 'int',
		'eatby' => 'datetime',
		'sellby' => 'datetime',
		'fk_entrepot' => 'int',
		'value' => 'float',
		'price' => 'float',
		'type_mouvement' => 'int',
		'fk_user_author' => 'int',
		'fk_project' => 'int',
		'fk_origin' => 'int',
		'fk_projet' => 'int'
	];

	protected $fillable = [
		'tms',
		'datem',
		'fk_product',
		'batch',
		'eatby',
		'sellby',
		'fk_entrepot',
		'value',
		'price',
		'type_mouvement',
		'fk_user_author',
		'label',
		'inventorycode',
		'fk_project',
		'fk_origin',
		'origintype',
		'model_pdf',
		'fk_projet'
	];

	public function llx_mrp_productions()
	{
		return $this->hasMany(LlxMrpProduction::class, 'fk_stock_movement');
	}
}
