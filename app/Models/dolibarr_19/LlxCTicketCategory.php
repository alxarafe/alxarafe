<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCTicketCategory
 *
 * @property int $rowid
 * @property int|null $entity
 * @property string $code
 * @property string $label
 * @property int|null $public
 * @property int|null $use_default
 * @property int $fk_parent
 * @property string|null $force_severity
 * @property string|null $description
 * @property int $pos
 * @property int|null $active
 *
 * @package App\Models
 */
class LlxCTicketCategory extends Model
{
	protected $table = 'llx_c_ticket_category';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'public' => 'int',
		'use_default' => 'int',
		'fk_parent' => 'int',
		'pos' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'entity',
		'code',
		'label',
		'public',
		'use_default',
		'fk_parent',
		'force_severity',
		'description',
		'pos',
		'active'
	];
}
