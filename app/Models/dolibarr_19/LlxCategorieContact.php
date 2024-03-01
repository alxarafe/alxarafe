<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieContact
 *
 * @property int $fk_categorie
 * @property int $fk_socpeople
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxSocperson $llx_socperson
 *
 * @package App\Models
 */
class LlxCategorieContact extends Model
{
	protected $table = 'llx_categorie_contact';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_socpeople' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_socperson()
	{
		return $this->belongsTo(LlxSocperson::class, 'fk_socpeople');
	}
}
