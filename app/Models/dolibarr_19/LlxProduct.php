<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProduct
 *
 * @property int $rowid
 * @property string $ref
 * @property int $entity
 * @property string|null $ref_ext
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int|null $fk_parent
 * @property string $label
 * @property string|null $description
 * @property string|null $note_public
 * @property string|null $note
 * @property string|null $customcode
 * @property int|null $fk_country
 * @property int|null $fk_state
 * @property float|null $price
 * @property float|null $price_ttc
 * @property float|null $price_min
 * @property float|null $price_min_ttc
 * @property string|null $price_base_type
 * @property float|null $cost_price
 * @property string|null $default_vat_code
 * @property float|null $tva_tx
 * @property int $recuperableonly
 * @property float|null $localtax1_tx
 * @property string $localtax1_type
 * @property float|null $localtax2_tx
 * @property string $localtax2_type
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $tosell
 * @property int|null $tobuy
 * @property int|null $onportal
 * @property int $tobatch
 * @property int $sell_or_eat_by_mandatory
 * @property string|null $batch_mask
 * @property int|null $fk_product_type
 * @property string|null $duration
 * @property float|null $seuil_stock_alerte
 * @property string|null $url
 * @property string|null $barcode
 * @property int|null $fk_barcode_type
 * @property string|null $accountancy_code_sell
 * @property string|null $accountancy_code_sell_intra
 * @property string|null $accountancy_code_sell_export
 * @property string|null $accountancy_code_buy
 * @property string|null $accountancy_code_buy_intra
 * @property string|null $accountancy_code_buy_export
 * @property string|null $partnumber
 * @property float|null $net_measure
 * @property int|null $net_measure_units
 * @property float|null $weight
 * @property int|null $weight_units
 * @property float|null $length
 * @property int|null $length_units
 * @property float|null $width
 * @property int|null $width_units
 * @property float|null $height
 * @property int|null $height_units
 * @property float|null $surface
 * @property int|null $surface_units
 * @property float|null $volume
 * @property int|null $volume_units
 * @property int $stockable_product
 * @property float|null $stock
 * @property float $pmp
 * @property float|null $fifo
 * @property float|null $lifo
 * @property int|null $fk_default_warehouse
 * @property string|null $canvas
 * @property int|null $finished
 * @property int|null $lifetime
 * @property int|null $qc_frequency
 * @property int|null $hidden
 * @property string|null $import_key
 * @property string|null $model_pdf
 * @property int|null $fk_price_expression
 * @property float|null $desiredstock
 * @property int|null $fk_unit
 * @property int|null $price_autogen
 * @property int|null $fk_project
 * @property int|null $mandatory_period
 * @property int|null $fk_default_bom
 * @property int|null $fk_default_workstation
 *
 * @property LlxCBarcodeType|null $llx_c_barcode_type
 * @property LlxEntrepot|null $llx_entrepot
 * @property LlxCProductNature|null $llx_c_product_nature
 * @property LlxCCountry|null $llx_c_country
 * @property LlxCUnit|null $llx_c_unit
 * @property Collection|LlxCategorieProduct[] $llx_categorie_products
 * @property Collection|LlxContratdet[] $llx_contratdets
 * @property Collection|LlxMrpProduction[] $llx_mrp_productions
 * @property Collection|LlxProductCustomerPrice[] $llx_product_customer_prices
 * @property Collection|LlxProductFournisseurPrice[] $llx_product_fournisseur_prices
 * @property Collection|LlxProductLang[] $llx_product_langs
 * @property Collection|LlxProductPrice[] $llx_product_prices
 * @property Collection|LlxProductStock[] $llx_product_stocks
 *
 * @package App\Models
 */
class LlxProduct extends Model
{
	protected $table = 'llx_product';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_parent' => 'int',
		'fk_country' => 'int',
		'fk_state' => 'int',
		'price' => 'float',
		'price_ttc' => 'float',
		'price_min' => 'float',
		'price_min_ttc' => 'float',
		'cost_price' => 'float',
		'tva_tx' => 'float',
		'recuperableonly' => 'int',
		'localtax1_tx' => 'float',
		'localtax2_tx' => 'float',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'tosell' => 'int',
		'tobuy' => 'int',
		'onportal' => 'int',
		'tobatch' => 'int',
		'sell_or_eat_by_mandatory' => 'int',
		'fk_product_type' => 'int',
		'seuil_stock_alerte' => 'float',
		'fk_barcode_type' => 'int',
		'net_measure' => 'float',
		'net_measure_units' => 'int',
		'weight' => 'float',
		'weight_units' => 'int',
		'length' => 'float',
		'length_units' => 'int',
		'width' => 'float',
		'width_units' => 'int',
		'height' => 'float',
		'height_units' => 'int',
		'surface' => 'float',
		'surface_units' => 'int',
		'volume' => 'float',
		'volume_units' => 'int',
		'stockable_product' => 'int',
		'stock' => 'float',
		'pmp' => 'float',
		'fifo' => 'float',
		'lifo' => 'float',
		'fk_default_warehouse' => 'int',
		'finished' => 'int',
		'lifetime' => 'int',
		'qc_frequency' => 'int',
		'hidden' => 'int',
		'fk_price_expression' => 'int',
		'desiredstock' => 'float',
		'fk_unit' => 'int',
		'price_autogen' => 'int',
		'fk_project' => 'int',
		'mandatory_period' => 'int',
		'fk_default_bom' => 'int',
		'fk_default_workstation' => 'int'
	];

	protected $fillable = [
		'ref',
		'entity',
		'ref_ext',
		'datec',
		'tms',
		'fk_parent',
		'label',
		'description',
		'note_public',
		'note',
		'customcode',
		'fk_country',
		'fk_state',
		'price',
		'price_ttc',
		'price_min',
		'price_min_ttc',
		'price_base_type',
		'cost_price',
		'default_vat_code',
		'tva_tx',
		'recuperableonly',
		'localtax1_tx',
		'localtax1_type',
		'localtax2_tx',
		'localtax2_type',
		'fk_user_author',
		'fk_user_modif',
		'tosell',
		'tobuy',
		'onportal',
		'tobatch',
		'sell_or_eat_by_mandatory',
		'batch_mask',
		'fk_product_type',
		'duration',
		'seuil_stock_alerte',
		'url',
		'barcode',
		'fk_barcode_type',
		'accountancy_code_sell',
		'accountancy_code_sell_intra',
		'accountancy_code_sell_export',
		'accountancy_code_buy',
		'accountancy_code_buy_intra',
		'accountancy_code_buy_export',
		'partnumber',
		'net_measure',
		'net_measure_units',
		'weight',
		'weight_units',
		'length',
		'length_units',
		'width',
		'width_units',
		'height',
		'height_units',
		'surface',
		'surface_units',
		'volume',
		'volume_units',
		'stockable_product',
		'stock',
		'pmp',
		'fifo',
		'lifo',
		'fk_default_warehouse',
		'canvas',
		'finished',
		'lifetime',
		'qc_frequency',
		'hidden',
		'import_key',
		'model_pdf',
		'fk_price_expression',
		'desiredstock',
		'fk_unit',
		'price_autogen',
		'fk_project',
		'mandatory_period',
		'fk_default_bom',
		'fk_default_workstation'
	];

	public function llx_c_barcode_type()
	{
		return $this->belongsTo(LlxCBarcodeType::class, 'fk_barcode_type');
	}

	public function llx_entrepot()
	{
		return $this->belongsTo(LlxEntrepot::class, 'fk_default_warehouse');
	}

	public function llx_c_product_nature()
	{
		return $this->belongsTo(LlxCProductNature::class, 'finished', 'code');
	}

	public function llx_c_country()
	{
		return $this->belongsTo(LlxCCountry::class, 'fk_country');
	}

	public function llx_c_unit()
	{
		return $this->belongsTo(LlxCUnit::class, 'fk_unit');
	}

	public function llx_categorie_products()
	{
		return $this->hasMany(LlxCategorieProduct::class, 'fk_product');
	}

	public function llx_contratdets()
	{
		return $this->hasMany(LlxContratdet::class, 'fk_product');
	}

	public function llx_mrp_productions()
	{
		return $this->hasMany(LlxMrpProduction::class, 'fk_product');
	}

	public function llx_product_customer_prices()
	{
		return $this->hasMany(LlxProductCustomerPrice::class, 'fk_product');
	}

	public function llx_product_fournisseur_prices()
	{
		return $this->hasMany(LlxProductFournisseurPrice::class, 'fk_product');
	}

	public function llx_product_langs()
	{
		return $this->hasMany(LlxProductLang::class, 'fk_product');
	}

	public function llx_product_prices()
	{
		return $this->hasMany(LlxProductPrice::class, 'fk_product');
	}

	public function llx_product_stocks()
	{
		return $this->hasMany(LlxProductStock::class, 'fk_product');
	}
}
