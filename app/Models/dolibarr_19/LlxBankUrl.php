<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBankUrl
 *
 * @property int $rowid
 * @property int|null $fk_bank
 * @property int|null $url_id
 * @property string|null $url
 * @property string|null $label
 * @property string $type
 *
 * @package App\Models
 */
class LlxBankUrl extends Model
{
	protected $table = 'llx_bank_url';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_bank' => 'int',
		'url_id' => 'int'
	];

	protected $fillable = [
		'fk_bank',
		'url_id',
		'url',
		'label',
		'type'
	];
}
