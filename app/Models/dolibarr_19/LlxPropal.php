<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPropal
 *
 * @property int $rowid
 * @property string $ref
 * @property int $entity
 * @property string|null $ref_ext
 * @property string|null $ref_client
 * @property int|null $fk_soc
 * @property int|null $fk_projet
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property Carbon|null $datep
 * @property Carbon|null $fin_validite
 * @property Carbon|null $date_valid
 * @property Carbon|null $date_signature
 * @property Carbon|null $date_cloture
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property int|null $fk_user_signature
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
 * @property string|null $deposit_percent
 * @property int|null $fk_mode_reglement
 * @property string|null $online_sign_ip
 * @property string|null $online_sign_name
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property Carbon|null $date_livraison
 * @property int|null $fk_shipping_method
 * @property int|null $fk_warehouse
 * @property int|null $fk_availability
 * @property int|null $fk_input_reason
 * @property int|null $fk_incoterms
 * @property string|null $location_incoterms
 * @property string|null $import_key
 * @property string|null $extraparams
 * @property int|null $fk_delivery_address
 * @property int|null $fk_multicurrency
 * @property string|null $multicurrency_code
 * @property float|null $multicurrency_tx
 * @property float|null $multicurrency_total_ht
 * @property float|null $multicurrency_total_tva
 * @property float|null $multicurrency_total_ttc
 *
 * @property LlxProjet|null $llx_projet
 * @property LlxSociete|null $llx_societe
 * @property LlxUser|null $llx_user
 * @property Collection|LlxPropaldet[] $llx_propaldets
 *
 * @package App\Models
 */
class LlxPropal extends Model
{
	protected $table = 'llx_propal';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_soc' => 'int',
		'fk_projet' => 'int',
		'tms' => 'datetime',
		'datec' => 'datetime',
		'datep' => 'datetime',
		'fin_validite' => 'datetime',
		'date_valid' => 'datetime',
		'date_signature' => 'datetime',
		'date_cloture' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_user_signature' => 'int',
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
		'fk_warehouse' => 'int',
		'fk_availability' => 'int',
		'fk_input_reason' => 'int',
		'fk_incoterms' => 'int',
		'fk_delivery_address' => 'int',
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
		'ref_client',
		'fk_soc',
		'fk_projet',
		'tms',
		'datec',
		'datep',
		'fin_validite',
		'date_valid',
		'date_signature',
		'date_cloture',
		'fk_user_author',
		'fk_user_modif',
		'fk_user_valid',
		'fk_user_signature',
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
		'deposit_percent',
		'fk_mode_reglement',
		'online_sign_ip',
		'online_sign_name',
		'note_private',
		'note_public',
		'model_pdf',
		'last_main_doc',
		'date_livraison',
		'fk_shipping_method',
		'fk_warehouse',
		'fk_availability',
		'fk_input_reason',
		'fk_incoterms',
		'location_incoterms',
		'import_key',
		'extraparams',
		'fk_delivery_address',
		'fk_multicurrency',
		'multicurrency_code',
		'multicurrency_tx',
		'multicurrency_total_ht',
		'multicurrency_total_tva',
		'multicurrency_total_ttc'
	];

	public function llx_projet()
	{
		return $this->belongsTo(LlxProjet::class, 'fk_projet');
	}

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_valid');
	}

	public function llx_propaldets()
	{
		return $this->hasMany(LlxPropaldet::class, 'fk_propal');
	}
}
