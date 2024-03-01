<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxActioncommResource
 *
 * @property int $rowid
 * @property int $fk_actioncomm
 * @property string $element_type
 * @property int $fk_element
 * @property string|null $answer_status
 * @property int|null $mandatory
 * @property int|null $transparency
 *
 * @package App\Models
 */
class LlxActioncommResource extends Model
{
	protected $table = 'llx_actioncomm_resources';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_actioncomm' => 'int',
		'fk_element' => 'int',
		'mandatory' => 'int',
		'transparency' => 'int'
	];

	protected $fillable = [
		'fk_actioncomm',
		'element_type',
		'fk_element',
		'answer_status',
		'mandatory',
		'transparency'
	];
}
