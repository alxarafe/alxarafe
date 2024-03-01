<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxElementElement
 *
 * @property int $rowid
 * @property int $fk_source
 * @property string $sourcetype
 * @property int $fk_target
 * @property string $targettype
 *
 * @package App\Models
 */
class LlxElementElement extends Model
{
	protected $table = 'llx_element_element';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_source' => 'int',
		'fk_target' => 'int'
	];

	protected $fillable = [
		'fk_source',
		'sourcetype',
		'fk_target',
		'targettype'
	];
}
