<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxAccountingBookkeeping
 *
 * @property int $rowid
 * @property int $entity
 * @property int $piece_num
 * @property Carbon $doc_date
 * @property string $doc_type
 * @property string $doc_ref
 * @property int $fk_doc
 * @property int $fk_docdet
 * @property string|null $thirdparty_code
 * @property string|null $subledger_account
 * @property string|null $subledger_label
 * @property string $numero_compte
 * @property string $label_compte
 * @property string|null $label_operation
 * @property float $debit
 * @property float $credit
 * @property float|null $montant
 * @property string|null $sens
 * @property float|null $multicurrency_amount
 * @property string|null $multicurrency_code
 * @property string|null $lettering_code
 * @property Carbon|null $date_lettering
 * @property Carbon|null $date_lim_reglement
 * @property int $fk_user_author
 * @property int|null $fk_user_modif
 * @property Carbon|null $date_creation
 * @property Carbon|null $tms
 * @property int|null $fk_user
 * @property string $code_journal
 * @property string|null $journal_label
 * @property Carbon|null $date_validated
 * @property Carbon|null $date_export
 * @property string|null $import_key
 * @property string|null $extraparams
 *
 * @package App\Models
 */
class LlxAccountingBookkeeping extends Model
{
	protected $table = 'llx_accounting_bookkeeping';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'piece_num' => 'int',
		'doc_date' => 'datetime',
		'fk_doc' => 'int',
		'fk_docdet' => 'int',
		'debit' => 'float',
		'credit' => 'float',
		'montant' => 'float',
		'multicurrency_amount' => 'float',
		'date_lettering' => 'datetime',
		'date_lim_reglement' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user' => 'int',
		'date_validated' => 'datetime',
		'date_export' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'piece_num',
		'doc_date',
		'doc_type',
		'doc_ref',
		'fk_doc',
		'fk_docdet',
		'thirdparty_code',
		'subledger_account',
		'subledger_label',
		'numero_compte',
		'label_compte',
		'label_operation',
		'debit',
		'credit',
		'montant',
		'sens',
		'multicurrency_amount',
		'multicurrency_code',
		'lettering_code',
		'date_lettering',
		'date_lim_reglement',
		'fk_user_author',
		'fk_user_modif',
		'date_creation',
		'tms',
		'fk_user',
		'code_journal',
		'journal_label',
		'date_validated',
		'date_export',
		'import_key',
		'extraparams'
	];
}
