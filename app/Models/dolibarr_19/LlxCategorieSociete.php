<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieSociete
 *
 * @property int $fk_categorie
 * @property int $fk_soc
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxSociete $llx_societe
 *
 * @package App\Models
 */
class LlxCategorieSociete extends Model
{
	protected $table = 'llx_categorie_societe';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_soc' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}
}
