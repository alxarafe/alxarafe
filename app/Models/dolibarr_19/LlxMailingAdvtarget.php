<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxMailingAdvtarget
 *
 * @property int $rowid
 * @property string $name
 * @property int $entity
 * @property int $fk_element
 * @property string $type_element
 * @property string|null $filtervalue
 * @property int $fk_user_author
 * @property Carbon $datec
 * @property int $fk_user_mod
 * @property Carbon $tms
 *
 * @package App\Models
 */
class LlxMailingAdvtarget extends Model
{
	protected $table = 'llx_mailing_advtarget';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_element' => 'int',
		'fk_user_author' => 'int',
		'datec' => 'datetime',
		'fk_user_mod' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'name',
		'entity',
		'fk_element',
		'type_element',
		'filtervalue',
		'fk_user_author',
		'datec',
		'fk_user_mod',
		'tms'
	];
}
