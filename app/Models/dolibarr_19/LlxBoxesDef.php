<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBoxesDef
 *
 * @property int $rowid
 * @property string $file
 * @property int $entity
 * @property int $fk_user
 * @property Carbon|null $tms
 * @property string|null $note
 *
 * @property Collection|LlxBox[] $llx_boxes
 *
 * @package App\Models
 */
class LlxBoxesDef extends Model
{
	protected $table = 'llx_boxes_def';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_user' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'file',
		'entity',
		'fk_user',
		'tms',
		'note'
	];

	public function llx_boxes()
	{
		return $this->hasMany(LlxBox::class, 'box_id');
	}
}
