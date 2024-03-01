<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBookmark
 *
 * @property int $rowid
 * @property int $fk_user
 * @property Carbon|null $dateb
 * @property string|null $url
 * @property string|null $target
 * @property string|null $title
 * @property string|null $favicon
 * @property int|null $position
 * @property int $entity
 *
 * @package App\Models
 */
class LlxBookmark extends Model
{
	protected $table = 'llx_bookmark';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_user' => 'int',
		'dateb' => 'datetime',
		'position' => 'int',
		'entity' => 'int'
	];

	protected $fillable = [
		'fk_user',
		'dateb',
		'url',
		'target',
		'title',
		'favicon',
		'position',
		'entity'
	];
}
