<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBankCateg
 *
 * @property int $rowid
 * @property string|null $label
 * @property int $entity
 *
 * @package App\Models
 */
class LlxBankCateg extends Model
{
	protected $table = 'llx_bank_categ';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int'
	];

	protected $fillable = [
		'label',
		'entity'
	];
}
