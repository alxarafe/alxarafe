<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxElementTime
 *
 * @property int $rowid
 * @property string|null $ref_ext
 * @property int $fk_element
 * @property string $elementtype
 * @property Carbon|null $element_date
 * @property Carbon|null $element_datehour
 * @property int|null $element_date_withhour
 * @property float|null $element_duration
 * @property int|null $fk_product
 * @property int|null $fk_user
 * @property float|null $thm
 * @property int|null $invoice_id
 * @property int|null $invoice_line_id
 * @property int|null $intervention_id
 * @property int|null $intervention_line_id
 * @property string|null $import_key
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property string|null $note
 *
 * @package App\Models
 */
class LlxElementTime extends Model
{
	protected $table = 'llx_element_time';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_element' => 'int',
		'element_date' => 'datetime',
		'element_datehour' => 'datetime',
		'element_date_withhour' => 'int',
		'element_duration' => 'float',
		'fk_product' => 'int',
		'fk_user' => 'int',
		'thm' => 'float',
		'invoice_id' => 'int',
		'invoice_line_id' => 'int',
		'intervention_id' => 'int',
		'intervention_line_id' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'ref_ext',
		'fk_element',
		'elementtype',
		'element_date',
		'element_datehour',
		'element_date_withhour',
		'element_duration',
		'fk_product',
		'fk_user',
		'thm',
		'invoice_id',
		'invoice_line_id',
		'intervention_id',
		'intervention_line_id',
		'import_key',
		'datec',
		'tms',
		'note'
	];
}
