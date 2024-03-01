<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCPartnershipType
 *
 * @property int $rowid
 * @property int $entity
 * @property string $code
 * @property string $label
 * @property string|null $keyword
 * @property int $active
 *
 * @package App\Models
 */
class LlxCPartnershipType extends Model
{
	protected $table = 'llx_c_partnership_type';
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
		'keyword',
		'active'
	];
}
