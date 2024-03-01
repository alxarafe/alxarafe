<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCPaperFormat
 *
 * @property int $rowid
 * @property string $code
 * @property string $label
 * @property float|null $width
 * @property float|null $height
 * @property string $unit
 * @property int $active
 * @property string|null $module
 *
 * @package App\Models
 */
class LlxCPaperFormat extends Model
{
	protected $table = 'llx_c_paper_format';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'width' => 'float',
		'height' => 'float',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'width',
		'height',
		'unit',
		'active',
		'module'
	];
}
