<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxExportModel
 *
 * @property int $rowid
 * @property int|null $entity
 * @property int $fk_user
 * @property string $label
 * @property string $type
 * @property string $field
 * @property string|null $filter
 *
 * @package App\Models
 */
class LlxExportModel extends Model
{
	protected $table = 'llx_export_model';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_user' => 'int'
	];

	protected $fillable = [
		'entity',
		'fk_user',
		'label',
		'type',
		'field',
		'filter'
	];
}
