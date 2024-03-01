<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPropalMergePdfProduct
 *
 * @property int $rowid
 * @property int $fk_product
 * @property string $file_name
 * @property string|null $lang
 * @property int|null $fk_user_author
 * @property int $fk_user_mod
 * @property Carbon $datec
 * @property Carbon|null $tms
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxPropalMergePdfProduct extends Model
{
	protected $table = 'llx_propal_merge_pdf_product';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_product' => 'int',
		'fk_user_author' => 'int',
		'fk_user_mod' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'fk_product',
		'file_name',
		'lang',
		'fk_user_author',
		'fk_user_mod',
		'datec',
		'tms',
		'import_key'
	];
}
