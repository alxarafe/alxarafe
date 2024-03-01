<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCFormatCard
 *
 * @property int $rowid
 * @property string $code
 * @property string $name
 * @property string $paper_size
 * @property string $orientation
 * @property string $metric
 * @property float $leftmargin
 * @property float $topmargin
 * @property int $nx
 * @property int $ny
 * @property float $spacex
 * @property float $spacey
 * @property float $width
 * @property float $height
 * @property int $font_size
 * @property float $custom_x
 * @property float $custom_y
 * @property int $active
 *
 * @package App\Models
 */
class LlxCFormatCard extends Model
{
	protected $table = 'llx_c_format_cards';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'leftmargin' => 'float',
		'topmargin' => 'float',
		'nx' => 'int',
		'ny' => 'int',
		'spacex' => 'float',
		'spacey' => 'float',
		'width' => 'float',
		'height' => 'float',
		'font_size' => 'int',
		'custom_x' => 'float',
		'custom_y' => 'float',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'name',
		'paper_size',
		'orientation',
		'metric',
		'leftmargin',
		'topmargin',
		'nx',
		'ny',
		'spacex',
		'spacey',
		'width',
		'height',
		'font_size',
		'custom_x',
		'custom_y',
		'active'
	];
}
