<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieProject
 *
 * @property int $fk_categorie
 * @property int $fk_project
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxProjet $llx_projet
 *
 * @package App\Models
 */
class LlxCategorieProject extends Model
{
	protected $table = 'llx_categorie_project';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_project' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_projet()
	{
		return $this->belongsTo(LlxProjet::class, 'fk_project');
	}
}
