<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCPaymentTerm
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $code
 * @property int|null $sortorder
 * @property int|null $active
 * @property string|null $libelle
 * @property string|null $libelle_facture
 * @property int|null $type_cdr
 * @property int|null $nbjour
 * @property int|null $decalage
 * @property string|null $deposit_percent
 * @property string|null $module
 * @property int $position
 *
 * @package App\Models
 */
class LlxCPaymentTerm extends Model
{
	protected $table = 'llx_c_payment_term';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'sortorder' => 'int',
		'active' => 'int',
		'type_cdr' => 'int',
		'nbjour' => 'int',
		'decalage' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
		'entity',
		'code',
		'sortorder',
		'active',
		'libelle',
		'libelle_facture',
		'type_cdr',
		'nbjour',
		'decalage',
		'deposit_percent',
		'module',
		'position'
	];
}
