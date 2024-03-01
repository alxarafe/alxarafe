<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxComment
 *
 * @property int $rowid
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property string $description
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_element
 * @property string|null $element_type
 * @property int|null $entity
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxComment extends Model
{
	protected $table = 'llx_comment';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_element' => 'int',
		'entity' => 'int'
	];

	protected $fillable = [
		'datec',
		'tms',
		'description',
		'fk_user_author',
		'fk_user_modif',
		'fk_element',
		'element_type',
		'entity',
		'import_key'
	];
}
