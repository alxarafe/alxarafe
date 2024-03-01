<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieMember
 *
 * @property int $fk_categorie
 * @property int $fk_member
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxAdherent $llx_adherent
 *
 * @package App\Models
 */
class LlxCategorieMember extends Model
{
	protected $table = 'llx_categorie_member';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_member' => 'int'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_adherent()
	{
		return $this->belongsTo(LlxAdherent::class, 'fk_member');
	}
}
