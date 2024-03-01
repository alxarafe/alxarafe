<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxEntrepot
 *
 * @property int $rowid
 * @property string $ref
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int $entity
 * @property int|null $fk_project
 * @property string|null $description
 * @property string|null $lieu
 * @property string|null $address
 * @property string|null $zip
 * @property string|null $town
 * @property int|null $fk_departement
 * @property int|null $fk_pays
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $barcode
 * @property int|null $fk_barcode_type
 * @property int|null $warehouse_usage
 * @property int|null $statut
 * @property int|null $fk_user_author
 * @property string|null $model_pdf
 * @property string|null $import_key
 * @property int|null $fk_parent
 *
 * @property Collection|LlxCategorieWarehouse[] $llx_categorie_warehouses
 * @property Collection|LlxProduct[] $llx_products
 * @property Collection|LlxProductStock[] $llx_product_stocks
 *
 * @package App\Models
 */
class LlxEntrepot extends Model
{
	protected $table = 'llx_entrepot';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datec' => 'datetime',
		'tms' => 'datetime',
		'entity' => 'int',
		'fk_project' => 'int',
		'fk_departement' => 'int',
		'fk_pays' => 'int',
		'fk_barcode_type' => 'int',
		'warehouse_usage' => 'int',
		'statut' => 'int',
		'fk_user_author' => 'int',
		'fk_parent' => 'int'
	];

	protected $fillable = [
		'ref',
		'datec',
		'tms',
		'entity',
		'fk_project',
		'description',
		'lieu',
		'address',
		'zip',
		'town',
		'fk_departement',
		'fk_pays',
		'phone',
		'fax',
		'barcode',
		'fk_barcode_type',
		'warehouse_usage',
		'statut',
		'fk_user_author',
		'model_pdf',
		'import_key',
		'fk_parent'
	];

	public function llx_categorie_warehouses()
	{
		return $this->hasMany(LlxCategorieWarehouse::class, 'fk_warehouse');
	}

	public function llx_products()
	{
		return $this->hasMany(LlxProduct::class, 'fk_default_warehouse');
	}

	public function llx_product_stocks()
	{
		return $this->hasMany(LlxProductStock::class, 'fk_entrepot');
	}
}
