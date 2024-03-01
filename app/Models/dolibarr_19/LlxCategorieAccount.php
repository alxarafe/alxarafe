<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieAccount
 *
 * @property int $fk_categorie
 * @property int $fk_account
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxBankAccount $llx_bank_account
 *
 * @package App\Models
 */
class LlxCategorieAccount extends Model
{
	protected $table = 'llx_categorie_account';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_account' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_bank_account()
	{
		return $this->belongsTo(LlxBankAccount::class, 'fk_account');
	}
}
