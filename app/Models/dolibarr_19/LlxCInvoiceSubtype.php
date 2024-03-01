<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCInvoiceSubtype
 *
 * @property int $rowid
 * @property int $entity
 * @property int $fk_country
 * @property string $code
 * @property string|null $label
 * @property int $active
 *
 * @package App\Models
 */
class LlxCInvoiceSubtype extends Model
{
	protected $table = 'llx_c_invoice_subtype';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_country' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'entity',
		'fk_country',
		'code',
		'label',
		'active'
	];
}
