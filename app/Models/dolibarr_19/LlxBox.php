<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBox
 *
 * @property int $rowid
 * @property int $entity
 * @property int $box_id
 * @property int $position
 * @property string $box_order
 * @property int $fk_user
 * @property int|null $maxline
 * @property string|null $params
 *
 * @property LlxBoxesDef $llx_boxes_def
 *
 * @package App\Models
 */
class LlxBox extends Model
{
	protected $table = 'llx_boxes';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'box_id' => 'int',
		'position' => 'int',
		'fk_user' => 'int',
		'maxline' => 'int'
	];

	protected $fillable = [
		'entity',
		'box_id',
		'position',
		'box_order',
		'fk_user',
		'maxline',
		'params'
	];

	public function llx_boxes_def()
	{
		return $this->belongsTo(LlxBoxesDef::class, 'box_id');
	}
}
