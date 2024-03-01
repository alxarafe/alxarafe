<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxStocktransferStocktransfer
 *
 * @property int $rowid
 * @property int $entity
 * @property string $ref
 * @property string|null $label
 * @property int|null $fk_soc
 * @property int|null $fk_project
 * @property int|null $fk_warehouse_source
 * @property int|null $fk_warehouse_destination
 * @property string|null $description
 * @property string|null $note_public
 * @property string|null $note_private
 * @property Carbon|null $tms
 * @property Carbon $date_creation
 * @property Carbon|null $date_prevue_depart
 * @property Carbon|null $date_reelle_depart
 * @property Carbon|null $date_prevue_arrivee
 * @property Carbon|null $date_reelle_arrivee
 * @property int|null $lead_time_for_warning
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $import_key
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property int $status
 * @property int|null $fk_incoterms
 * @property string|null $location_incoterms
 *
 * @property LlxUser $llx_user
 *
 * @package App\Models
 */
class LlxStocktransferStocktransfer extends Model
{
	protected $table = 'llx_stocktransfer_stocktransfer';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_soc' => 'int',
		'fk_project' => 'int',
		'fk_warehouse_source' => 'int',
		'fk_warehouse_destination' => 'int',
		'tms' => 'datetime',
		'date_creation' => 'datetime',
		'date_prevue_depart' => 'datetime',
		'date_reelle_depart' => 'datetime',
		'date_prevue_arrivee' => 'datetime',
		'date_reelle_arrivee' => 'datetime',
		'lead_time_for_warning' => 'int',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'status' => 'int',
		'fk_incoterms' => 'int'
	];

	protected $fillable = [
		'entity',
		'ref',
		'label',
		'fk_soc',
		'fk_project',
		'fk_warehouse_source',
		'fk_warehouse_destination',
		'description',
		'note_public',
		'note_private',
		'tms',
		'date_creation',
		'date_prevue_depart',
		'date_reelle_depart',
		'date_prevue_arrivee',
		'date_reelle_arrivee',
		'lead_time_for_warning',
		'fk_user_creat',
		'fk_user_modif',
		'import_key',
		'model_pdf',
		'last_main_doc',
		'status',
		'fk_incoterms',
		'location_incoterms'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}
}
