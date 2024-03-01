<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductLang
 *
 * @property int $rowid
 * @property int $fk_product
 * @property string $lang
 * @property string $label
 * @property string|null $description
 * @property string|null $note
 * @property string|null $import_key
 *
 * @property LlxProduct $llx_product
 *
 * @package App\Models
 */
class LlxProductLang extends Model
{
	protected $table = 'llx_product_lang';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_product' => 'int'
	];

	protected $fillable = [
		'fk_product',
		'lang',
		'label',
		'description',
		'note',
		'import_key'
	];

	public function llx_product()
	{
		return $this->belongsTo(LlxProduct::class, 'fk_product');
	}
}
