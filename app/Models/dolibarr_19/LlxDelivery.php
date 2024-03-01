<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxDelivery
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property string $ref
 * @property int $entity
 * @property int $fk_soc
 * @property string|null $ref_ext
 * @property string|null $ref_customer
 * @property Carbon|null $date_creation
 * @property int|null $fk_user_author
 * @property Carbon|null $date_valid
 * @property int|null $fk_user_valid
 * @property Carbon|null $date_delivery
 * @property int|null $fk_address
 * @property int|null $fk_statut
 * @property float|null $total_ht
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property int|null $fk_incoterms
 * @property string|null $location_incoterms
 * @property string|null $import_key
 * @property string|null $extraparams
 *
 * @property LlxSociete $llx_societe
 * @property LlxUser|null $llx_user
 * @property Collection|LlxDeliverydet[] $llx_deliverydets
 *
 * @package App\Models
 */
class LlxDelivery extends Model
{
	protected $table = 'llx_delivery';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'entity' => 'int',
		'fk_soc' => 'int',
		'date_creation' => 'datetime',
		'fk_user_author' => 'int',
		'date_valid' => 'datetime',
		'fk_user_valid' => 'int',
		'date_delivery' => 'datetime',
		'fk_address' => 'int',
		'fk_statut' => 'int',
		'total_ht' => 'float',
		'fk_incoterms' => 'int'
	];

	protected $fillable = [
		'tms',
		'ref',
		'entity',
		'fk_soc',
		'ref_ext',
		'ref_customer',
		'date_creation',
		'fk_user_author',
		'date_valid',
		'fk_user_valid',
		'date_delivery',
		'fk_address',
		'fk_statut',
		'total_ht',
		'note_private',
		'note_public',
		'model_pdf',
		'last_main_doc',
		'fk_incoterms',
		'location_incoterms',
		'import_key',
		'extraparams'
	];

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_valid');
	}

	public function llx_deliverydets()
	{
		return $this->hasMany(LlxDeliverydet::class, 'fk_delivery');
	}
}
