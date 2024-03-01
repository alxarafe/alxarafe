<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxSupplierProposal
 *
 * @property int $rowid
 * @property string $ref
 * @property int $entity
 * @property string|null $ref_ext
 * @property int|null $fk_soc
 * @property int|null $fk_projet
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property Carbon|null $date_valid
 * @property Carbon|null $date_cloture
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property int|null $fk_user_cloture
 * @property int $fk_statut
 * @property float|null $price
 * @property float|null $remise_percent
 * @property float|null $remise_absolue
 * @property float|null $remise
 * @property float|null $total_ht
 * @property float|null $total_tva
 * @property float|null $localtax1
 * @property float|null $localtax2
 * @property float|null $total_ttc
 * @property int|null $fk_account
 * @property string|null $fk_currency
 * @property int|null $fk_cond_reglement
 * @property int|null $fk_mode_reglement
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property Carbon|null $date_livraison
 * @property int|null $fk_shipping_method
 * @property string|null $import_key
 * @property string|null $extraparams
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_tx
 * @property float|null $multicurrency_total_ht
 * @property float|null $multicurrency_total_tva
 * @property float|null $multicurrency_total_ttc
 *
 * @property Collection|LlxSupplierProposaldet[] $llx_supplier_proposaldets
 *
 * @package App\Models
 */
class LlxSupplierProposal extends Model
{
	protected $table = 'llx_supplier_proposal';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_soc' => 'int',
		'fk_projet' => 'int',
		'tms' => 'datetime',
		'datec' => 'datetime',
		'date_valid' => 'datetime',
		'date_cloture' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_user_cloture' => 'int',
		'fk_statut' => 'int',
		'price' => 'float',
		'remise_percent' => 'float',
		'remise_absolue' => 'float',
		'remise' => 'float',
		'total_ht' => 'float',
		'total_tva' => 'float',
		'localtax1' => 'float',
		'localtax2' => 'float',
		'total_ttc' => 'float',
		'fk_account' => 'int',
		'fk_cond_reglement' => 'int',
		'fk_mode_reglement' => 'int',
		'date_livraison' => 'datetime',
		'fk_shipping_method' => 'int',
		'fk_multicurrency' => 'int',
		'multicurrency_tx' => 'float',
		'multicurrency_total_ht' => 'float',
		'multicurrency_total_tva' => 'float',
		'multicurrency_total_ttc' => 'float'
	];

	protected $fillable = [
		'ref',
		'entity',
		'ref_ext',
		'fk_soc',
		'fk_projet',
		'tms',
		'datec',
		'date_valid',
		'date_cloture',
		'fk_user_author',
		'fk_user_modif',
		'fk_user_valid',
		'fk_user_cloture',
		'fk_statut',
		'price',
		'remise_percent',
		'remise_absolue',
		'remise',
		'total_ht',
		'total_tva',
		'localtax1',
		'localtax2',
		'total_ttc',
		'fk_account',
		'fk_currency',
		'fk_cond_reglement',
		'fk_mode_reglement',
		'note_private',
		'note_public',
		'model_pdf',
		'last_main_doc',
		'date_livraison',
		'fk_shipping_method',
		'import_key',
		'extraparams',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_tx',
		'multicurrency_total_ht',
		'multicurrency_total_tva',
		'multicurrency_total_ttc'
	];

	public function llx_supplier_proposaldets()
	{
		return $this->hasMany(LlxSupplierProposaldet::class, 'fk_supplier_proposal');
	}
}
