<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxWebsitePage
 *
 * @property int $rowid
 * @property int $fk_website
 * @property string $type_container
 * @property string $pageurl
 * @property string|null $aliasalt
 * @property string|null $title
 * @property string|null $description
 * @property string|null $image
 * @property string|null $keywords
 * @property string|null $lang
 * @property int|null $fk_page
 * @property int|null $allowed_in_frames
 * @property string|null $htmlheader
 * @property string|null $content
 * @property int|null $status
 * @property string|null $grabbed_from
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $author_alias
 * @property Carbon|null $date_creation
 * @property Carbon|null $tms
 * @property string|null $import_key
 * @property string|null $object_type
 * @property string|null $fk_object
 *
 * @property LlxWebsite $llx_website
 * @property Collection|LlxCategorieWebsitePage[] $llx_categorie_website_pages
 *
 * @package App\Models
 */
class LlxWebsitePage extends Model
{
	protected $table = 'llx_website_page';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_website' => 'int',
		'fk_page' => 'int',
		'allowed_in_frames' => 'int',
		'status' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'fk_website',
		'type_container',
		'pageurl',
		'aliasalt',
		'title',
		'description',
		'image',
		'keywords',
		'lang',
		'fk_page',
		'allowed_in_frames',
		'htmlheader',
		'content',
		'status',
		'grabbed_from',
		'fk_user_creat',
		'fk_user_modif',
		'author_alias',
		'date_creation',
		'tms',
		'import_key',
		'object_type',
		'fk_object'
	];

	public function llx_website()
	{
		return $this->belongsTo(LlxWebsite::class, 'fk_website');
	}

	public function llx_categorie_website_pages()
	{
		return $this->hasMany(LlxCategorieWebsitePage::class, 'fk_website_page');
	}
}
