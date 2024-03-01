<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCActionTrigger
 *
 * @property int $rowid
 * @property string $elementtype
 * @property string $code
 * @property string|null $contexts
 * @property string $label
 * @property string|null $description
 * @property int|null $rang
 *
 * @package App\Models
 */
class LlxCActionTrigger extends Model
{
	protected $table = 'llx_c_action_trigger';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'rang' => 'int'
	];

	protected $fillable = [
		'elementtype',
		'code',
		'contexts',
		'label',
		'description',
		'rang'
	];
}
