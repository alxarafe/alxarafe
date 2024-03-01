<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxImportModel
 *
 * @property int $rowid
 * @property int $entity
 * @property int $fk_user
 * @property string $label
 * @property string $type
 * @property string $field
 *
 * @package App\Models
 */
class LlxImportModel extends Model
{
	protected $table = 'llx_import_model';
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
		'field'
	];
}
