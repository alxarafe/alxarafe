<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCTicketType
 *
 * @property int $rowid
 * @property int|null $entity
 * @property string $code
 * @property string $pos
 * @property string $label
 * @property int|null $active
 * @property int|null $use_default
 * @property string|null $description
 *
 * @package App\Models
 */
class LlxCTicketType extends Model
{
	protected $table = 'llx_c_ticket_type';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'active' => 'int',
		'use_default' => 'int'
	];

	protected $fillable = [
		'entity',
		'code',
		'pos',
		'label',
		'active',
		'use_default',
		'description'
	];
}
