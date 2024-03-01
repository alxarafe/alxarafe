<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxProductLot
 *
 * @property int $rowid
 * @property int|null $entity
 * @property int $fk_product
 * @property string|null $batch
 * @property string|null $note_public
 * @property string|null $note_private
 * @property Carbon|null $eatby
 * @property Carbon|null $sellby
 * @property Carbon|null $eol_date
 * @property Carbon|null $manufacturing_date
 * @property Carbon|null $scrapping_date
 * @property int|null $qc_frequency
 * @property int|null $lifetime
 * @property string|null $barcode
 * @property int|null $fk_barcode_type
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int|null $import_key
 *
 * @package App\Models
 */
class LlxProductLot extends Model
{
	protected $table = 'llx_product_lot';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_product' => 'int',
		'eatby' => 'datetime',
		'sellby' => 'datetime',
		'eol_date' => 'datetime',
		'manufacturing_date' => 'datetime',
		'scrapping_date' => 'datetime',
		'qc_frequency' => 'int',
		'lifetime' => 'int',
		'fk_barcode_type' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'import_key' => 'int'
	];

	protected $fillable = [
		'entity',
		'fk_product',
		'batch',
		'note_public',
		'note_private',
		'eatby',
		'sellby',
		'eol_date',
		'manufacturing_date',
		'scrapping_date',
		'qc_frequency',
		'lifetime',
		'barcode',
		'fk_barcode_type',
		'model_pdf',
		'last_main_doc',
		'datec',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'import_key'
	];
}
