<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCFieldList
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property string $element
 * @property int $entity
 * @property string $name
 * @property string $alias
 * @property string $title
 * @property string|null $align
 * @property int $sort
 * @property int $search
 * @property int $visible
 * @property string|null $enabled
 * @property int|null $rang
 *
 * @package App\Models
 */
class LlxCFieldList extends Model
{
	protected $table = 'llx_c_field_list';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'entity' => 'int',
		'sort' => 'int',
		'search' => 'int',
		'visible' => 'int',
		'rang' => 'int'
	];

	protected $fillable = [
		'tms',
		'element',
		'entity',
		'name',
		'alias',
		'title',
		'align',
		'sort',
		'search',
		'visible',
		'enabled',
		'rang'
	];
}
