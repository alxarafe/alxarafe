<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieLang
 *
 * @property int $rowid
 * @property int $fk_category
 * @property string $lang
 * @property string $label
 * @property string|null $description
 *
 * @property LlxCategorie $llx_categorie
 *
 * @package App\Models
 */
class LlxCategorieLang extends Model
{
	protected $table = 'llx_categorie_lang';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_category' => 'int'
	];

	protected $fillable = [
		'fk_category',
		'lang',
		'label',
		'description'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_category');
	}
}
