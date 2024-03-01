<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieWebsitePage
 *
 * @property int $fk_categorie
 * @property int $fk_website_page
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxWebsitePage $llx_website_page
 *
 * @package App\Models
 */
class LlxCategorieWebsitePage extends Model
{
	protected $table = 'llx_categorie_website_page';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_website_page' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_website_page()
	{
		return $this->belongsTo(LlxWebsitePage::class, 'fk_website_page');
	}
}
