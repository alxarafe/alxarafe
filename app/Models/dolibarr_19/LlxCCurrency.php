<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCCurrency
 *
 * @property string $code_iso
 * @property string $label
 * @property string|null $unicode
 * @property int $active
 *
 * @package App\Models
 */
class LlxCCurrency extends Model
{
	protected $table = 'llx_c_currencies';
	protected $primaryKey = 'code_iso';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'active' => 'int'
	];

	protected $fillable = [
		'label',
		'unicode',
		'active'
	];
}
