<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxExtrafield
 *
 * @property int $rowid
 * @property string $name
 * @property int $entity
 * @property string $elementtype
 * @property string $label
 * @property string|null $type
 * @property string|null $size
 * @property string|null $fieldcomputed
 * @property string|null $fielddefault
 * @property int|null $fieldunique
 * @property int|null $fieldrequired
 * @property string|null $perms
 * @property string|null $enabled
 * @property int|null $pos
 * @property int|null $alwayseditable
 * @property string|null $param
 * @property string|null $list
 * @property int|null $printable
 * @property bool|null $totalizable
 * @property string|null $langs
 * @property string|null $help
 * @property string|null $css
 * @property string|null $cssview
 * @property string|null $csslist
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 *
 * @package App\Models
 */
class LlxExtrafield extends Model
{
	protected $table = 'llx_extrafields';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fieldunique' => 'int',
		'fieldrequired' => 'int',
		'pos' => 'int',
		'alwayseditable' => 'int',
		'printable' => 'int',
		'totalizable' => 'bool',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'name',
		'entity',
		'elementtype',
		'label',
		'type',
		'size',
		'fieldcomputed',
		'fielddefault',
		'fieldunique',
		'fieldrequired',
		'perms',
		'enabled',
		'pos',
		'alwayseditable',
		'param',
		'list',
		'printable',
		'totalizable',
		'langs',
		'help',
		'css',
		'cssview',
		'csslist',
		'fk_user_author',
		'fk_user_modif',
		'datec',
		'tms'
	];
}
