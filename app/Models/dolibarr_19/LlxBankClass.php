<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBankClass
 *
 * @property int $lineid
 * @property int $fk_categ
 *
 * @package App\Models
 */
class LlxBankClass extends Model
{
	protected $table = 'llx_bank_class';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'lineid' => 'int',
		'fk_categ' => 'int'
	];
}
