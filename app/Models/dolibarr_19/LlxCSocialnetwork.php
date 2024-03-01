<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCSocialnetwork
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $code
 * @property string|null $label
 * @property string|null $url
 * @property string|null $icon
 * @property int $active
 *
 * @package App\Models
 */
class LlxCSocialnetwork extends Model
{
	protected $table = 'llx_c_socialnetworks';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'entity',
		'code',
		'label',
		'url',
		'icon',
		'active'
	];
}
