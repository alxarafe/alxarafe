<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxWebsite
 *
 * @property int $rowid
 * @property string $type_container
 * @property int $entity
 * @property string $ref
 * @property string|null $description
 * @property string|null $maincolor
 * @property string|null $maincolorbis
 * @property string|null $lang
 * @property string|null $otherlang
 * @property int|null $status
 * @property int|null $fk_default_home
 * @property int|null $use_manifest
 * @property string|null $virtualhost
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property Carbon|null $date_creation
 * @property int|null $position
 * @property Carbon|null $lastaccess
 * @property int|null $pageviews_previous_month
 * @property int|null $pageviews_month
 * @property int|null $pageviews_total
 * @property Carbon|null $tms
 * @property string|null $import_key
 *
 * @property Collection|LlxWebsitePage[] $llx_website_pages
 *
 * @package App\Models
 */
class LlxWebsite extends Model
{
	protected $table = 'llx_website';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'status' => 'int',
		'fk_default_home' => 'int',
		'use_manifest' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'date_creation' => 'datetime',
		'position' => 'int',
		'lastaccess' => 'datetime',
		'pageviews_previous_month' => 'int',
		'pageviews_month' => 'int',
		'pageviews_total' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'type_container',
		'entity',
		'ref',
		'description',
		'maincolor',
		'maincolorbis',
		'lang',
		'otherlang',
		'status',
		'fk_default_home',
		'use_manifest',
		'virtualhost',
		'fk_user_creat',
		'fk_user_modif',
		'date_creation',
		'position',
		'lastaccess',
		'pageviews_previous_month',
		'pageviews_month',
		'pageviews_total',
		'tms',
		'import_key'
	];

	public function llx_website_pages()
	{
		return $this->hasMany(LlxWebsitePage::class, 'fk_website');
	}
}
