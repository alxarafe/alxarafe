<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCEmailTemplate
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $module
 * @property string|null $type_template
 * @property string|null $lang
 * @property int $private
 * @property int|null $fk_user
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property string|null $label
 * @property int|null $position
 * @property int|null $defaultfortype
 * @property string|null $enabled
 * @property int $active
 * @property string|null $email_from
 * @property string|null $email_to
 * @property string|null $email_tocc
 * @property string|null $email_tobcc
 * @property string|null $topic
 * @property string|null $joinfiles
 * @property string|null $content
 * @property string|null $content_lines
 *
 * @package App\Models
 */
class LlxCEmailTemplate extends Model
{
	protected $table = 'llx_c_email_templates';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'private' => 'int',
		'fk_user' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'position' => 'int',
		'defaultfortype' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'entity',
		'module',
		'type_template',
		'lang',
		'private',
		'fk_user',
		'datec',
		'tms',
		'label',
		'position',
		'defaultfortype',
		'enabled',
		'active',
		'email_from',
		'email_to',
		'email_tocc',
		'email_tobcc',
		'topic',
		'joinfiles',
		'content',
		'content_lines'
	];
}
