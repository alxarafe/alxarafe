<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxMenu
 *
 * @property int $rowid
 * @property string $menu_handler
 * @property int $entity
 * @property string|null $module
 * @property string $type
 * @property string $mainmenu
 * @property string|null $leftmenu
 * @property int $fk_menu
 * @property string|null $fk_mainmenu
 * @property string|null $fk_leftmenu
 * @property int $position
 * @property string $url
 * @property string|null $target
 * @property string $titre
 * @property string|null $prefix
 * @property string|null $langs
 * @property int|null $level
 * @property string|null $perms
 * @property string|null $enabled
 * @property int $usertype
 * @property Carbon|null $tms
 *
 * @package App\Models
 */
class LlxMenu extends Model
{
	protected $table = 'llx_menu';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_menu' => 'int',
		'position' => 'int',
		'level' => 'int',
		'usertype' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'menu_handler',
		'entity',
		'module',
		'type',
		'mainmenu',
		'leftmenu',
		'fk_menu',
		'fk_mainmenu',
		'fk_leftmenu',
		'position',
		'url',
		'target',
		'titre',
		'prefix',
		'langs',
		'level',
		'perms',
		'enabled',
		'usertype',
		'tms'
	];
}
