<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieProduct
 *
 * @property int $fk_categorie
 * @property int $fk_product
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxProduct $llx_product
 *
 * @package App\Models
 */
class LlxCategorieProduct extends Model
{
	protected $table = 'llx_categorie_product';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_product' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_product()
	{
		return $this->belongsTo(LlxProduct::class, 'fk_product');
	}
}
