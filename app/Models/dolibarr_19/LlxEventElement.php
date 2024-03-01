<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxEventElement
 *
 * @property int $rowid
 * @property int $fk_source
 * @property int $fk_target
 * @property string $targettype
 *
 * @package App\Models
 */
class LlxEventElement extends Model
{
	protected $table = 'llx_event_element';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_source' => 'int',
		'fk_target' => 'int'
	];

	protected $fillable = [
		'fk_source',
		'fk_target',
		'targettype'
	];
}
