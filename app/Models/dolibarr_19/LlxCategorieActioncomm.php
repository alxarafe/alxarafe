<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieActioncomm
 *
 * @property int $fk_categorie
 * @property int $fk_actioncomm
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxActioncomm $llx_actioncomm
 *
 * @package App\Models
 */
class LlxCategorieActioncomm extends Model
{
	protected $table = 'llx_categorie_actioncomm';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_actioncomm' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_actioncomm()
	{
		return $this->belongsTo(LlxActioncomm::class, 'fk_actioncomm');
	}
}
