<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCProductbatchQcstatus
 *
 * @property int $rowid
 * @property int $entity
 * @property string $code
 * @property string $label
 * @property int $active
 *
 * @package App\Models
 */
class LlxCProductbatchQcstatus extends Model
{
	protected $table = 'llx_c_productbatch_qcstatus';
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
		'active'
	];
}
