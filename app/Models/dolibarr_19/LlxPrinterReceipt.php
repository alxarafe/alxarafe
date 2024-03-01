<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPrinterReceipt
 *
 * @property int $rowid
 * @property string|null $name
 * @property int|null $fk_type
 * @property int|null $fk_profile
 * @property string|null $parameter
 * @property int|null $entity
 *
 * @package App\Models
 */
class LlxPrinterReceipt extends Model
{
	protected $table = 'llx_printer_receipt';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_type' => 'int',
		'fk_profile' => 'int',
		'entity' => 'int'
	];

	protected $fillable = [
		'name',
		'fk_type',
		'fk_profile',
		'parameter',
		'entity'
	];
}
