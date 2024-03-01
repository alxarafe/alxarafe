<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieWarehouse
 *
 * @property int $fk_categorie
 * @property int $fk_warehouse
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxEntrepot $llx_entrepot
 *
 * @package App\Models
 */
class LlxCategorieWarehouse extends Model
{
	protected $table = 'llx_categorie_warehouse';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_warehouse' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_entrepot()
	{
		return $this->belongsTo(LlxEntrepot::class, 'fk_warehouse');
	}
}
