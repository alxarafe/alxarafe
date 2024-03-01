<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxExpedition
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property string $ref
 * @property int $entity
 * @property int $fk_soc
 * @property int|null $fk_projet
 * @property string|null $ref_ext
 * @property string|null $ref_customer
 * @property Carbon|null $date_creation
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property Carbon|null $date_valid
 * @property int|null $fk_user_valid
 * @property Carbon|null $date_delivery
 * @property Carbon|null $date_expedition
 * @property int|null $fk_address
 * @property int|null $fk_shipping_method
 * @property string|null $tracking_number
 * @property int|null $fk_statut
 * @property int|null $billed
 * @property float|null $height
 * @property float|null $width
 * @property int|null $size_units
 * @property float|null $size
 * @property int|null $weight_units
 * @property float|null $weight
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property int|null $fk_incoterms
 * @property string|null $location_incoterms
 * @property string|null $import_key
 * @property string|null $extraparams
 *
 * @property LlxCShipmentMode|null $llx_c_shipment_mode
 * @property LlxSociete $llx_societe
 * @property LlxUser|null $llx_user
 * @property Collection|LlxExpeditiondet[] $llx_expeditiondets
 *
 * @package App\Models
 */
class LlxExpedition extends Model
{
	protected $table = 'llx_expedition';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'entity' => 'int',
		'fk_soc' => 'int',
		'fk_projet' => 'int',
		'date_creation' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'date_valid' => 'datetime',
		'fk_user_valid' => 'int',
		'date_delivery' => 'datetime',
		'date_expedition' => 'datetime',
		'fk_address' => 'int',
		'fk_shipping_method' => 'int',
		'fk_statut' => 'int',
		'billed' => 'int',
		'height' => 'float',
		'width' => 'float',
		'size_units' => 'int',
		'size' => 'float',
		'weight_units' => 'int',
		'weight' => 'float',
		'fk_incoterms' => 'int'
	];

	protected $fillable = [
		'tms',
		'ref',
		'entity',
		'fk_soc',
		'fk_projet',
		'ref_ext',
		'ref_customer',
		'date_creation',
		'fk_user_author',
		'fk_user_modif',
		'date_valid',
		'fk_user_valid',
		'date_delivery',
		'date_expedition',
		'fk_address',
		'fk_shipping_method',
		'tracking_number',
		'fk_statut',
		'billed',
		'height',
		'width',
		'size_units',
		'size',
		'weight_units',
		'weight',
		'note_private',
		'note_public',
		'model_pdf',
		'last_main_doc',
		'fk_incoterms',
		'location_incoterms',
		'import_key',
		'extraparams'
	];

	public function llx_c_shipment_mode()
	{
		return $this->belongsTo(LlxCShipmentMode::class, 'fk_shipping_method');
	}

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_valid');
	}

	public function llx_expeditiondets()
	{
		return $this->hasMany(LlxExpeditiondet::class, 'fk_expedition');
	}
}
