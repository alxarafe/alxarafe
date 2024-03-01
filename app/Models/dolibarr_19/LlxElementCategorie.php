<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxElementCategorie
 *
 * @property int $rowid
 * @property int $fk_categorie
 * @property int $fk_element
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 *
 * @package App\Models
 */
class LlxElementCategorie extends Model
{
	protected $table = 'llx_element_categorie';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_element' => 'int'
	];

	protected $fillable = [
		'fk_categorie',
		'fk_element',
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}
}
