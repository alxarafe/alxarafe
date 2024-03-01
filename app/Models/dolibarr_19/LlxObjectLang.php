<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxObjectLang
 *
 * @property int $rowid
 * @property int $fk_object
 * @property string $type_object
 * @property string $property
 * @property string $lang
 * @property string|null $value
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxObjectLang extends Model
{
	protected $table = 'llx_object_lang';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_object' => 'int'
	];

	protected $fillable = [
		'fk_object',
		'type_object',
		'property',
		'lang',
		'value',
		'import_key'
	];
}
