<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPrinterReceiptTemplate
 *
 * @property int $rowid
 * @property string|null $name
 * @property string|null $template
 * @property int|null $entity
 *
 * @package App\Models
 */
class LlxPrinterReceiptTemplate extends Model
{
	protected $table = 'llx_printer_receipt_template';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int'
	];

	protected $fillable = [
		'name',
		'template',
		'entity'
	];
}
