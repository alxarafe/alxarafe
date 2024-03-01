<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieUser
 *
 * @property int $fk_categorie
 * @property int $fk_user
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxUser $llx_user
 *
 * @package App\Models
 */
class LlxCategorieUser extends Model
{
	protected $table = 'llx_categorie_user';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_user' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user');
	}
}
