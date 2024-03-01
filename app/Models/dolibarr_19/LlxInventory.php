<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxInventory
 *
 * @property int $rowid
 * @property int|null $entity
 * @property string|null $ref
 * @property Carbon|null $date_creation
 * @property Carbon|null $tms
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property int|null $fk_warehouse
 * @property int|null $fk_product
 * @property string|null $categories_product
 * @property int|null $status
 * @property string $title
 * @property Carbon|null $date_inventory
 * @property Carbon|null $date_validation
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxInventory extends Model
{
	protected $table = 'llx_inventory';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_warehouse' => 'int',
		'fk_product' => 'int',
		'status' => 'int',
		'date_inventory' => 'datetime',
		'date_validation' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'ref',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'fk_user_valid',
		'fk_warehouse',
		'fk_product',
		'categories_product',
		'status',
		'title',
		'date_inventory',
		'date_validation',
		'import_key'
	];
}
