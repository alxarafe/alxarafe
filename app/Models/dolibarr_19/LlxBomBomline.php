<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBomBomline
 *
 * @property int $rowid
 * @property int $fk_bom
 * @property int $fk_product
 * @property int|null $fk_bom_child
 * @property string|null $description
 * @property string|null $import_key
 * @property float $qty
 * @property int|null $qty_frozen
 * @property int|null $disable_stock_change
 * @property float $efficiency
 * @property int|null $fk_unit
 * @property int $position
 * @property int|null $fk_default_workstation
 *
 * @property LlxBomBom $llx_bom_bom
 *
 * @package App\Models
 */
class LlxBomBomline extends Model
{
	protected $table = 'llx_bom_bomline';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_bom' => 'int',
		'fk_product' => 'int',
		'fk_bom_child' => 'int',
		'qty' => 'float',
		'qty_frozen' => 'int',
		'disable_stock_change' => 'int',
		'efficiency' => 'float',
		'fk_unit' => 'int',
		'position' => 'int',
		'fk_default_workstation' => 'int'
	];

	protected $fillable = [
		'fk_bom',
		'fk_product',
		'fk_bom_child',
		'description',
		'import_key',
		'qty',
		'qty_frozen',
		'disable_stock_change',
		'efficiency',
		'fk_unit',
		'position',
		'fk_default_workstation'
	];

	public function llx_bom_bom()
	{
		return $this->belongsTo(LlxBomBom::class, 'fk_bom');
	}
}
