<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCBarcodeType
 *
 * @property int $rowid
 * @property string $code
 * @property int $entity
 * @property string $libelle
 * @property string $coder
 * @property string $example
 *
 * @property Collection|LlxProduct[] $llx_products
 * @property Collection|LlxProductFournisseurPrice[] $llx_product_fournisseur_prices
 *
 * @package App\Models
 */
class LlxCBarcodeType extends Model
{
	protected $table = 'llx_c_barcode_type';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int'
	];

	protected $fillable = [
		'code',
		'entity',
		'libelle',
		'coder',
		'example'
	];

	public function llx_products()
	{
		return $this->hasMany(LlxProduct::class, 'fk_barcode_type');
	}

	public function llx_product_fournisseur_prices()
	{
		return $this->hasMany(LlxProductFournisseurPrice::class, 'fk_barcode_type');
	}
}
