<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxMrpMo
 *
 * @property int $rowid
 * @property int $entity
 * @property string $ref
 * @property int|null $mrptype
 * @property string|null $label
 * @property float $qty
 * @property int|null $fk_warehouse
 * @property int|null $fk_soc
 * @property string|null $note_public
 * @property string|null $note_private
 * @property Carbon $date_creation
 * @property Carbon|null $date_valid
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property string|null $import_key
 * @property string|null $model_pdf
 * @property int $status
 * @property int $fk_product
 * @property Carbon|null $date_start_planned
 * @property Carbon|null $date_end_planned
 * @property int|null $fk_bom
 * @property int|null $fk_project
 * @property string|null $last_main_doc
 * @property int|null $fk_parent_line
 *
 * @property LlxUser $llx_user
 * @property Collection|LlxMrpProduction[] $llx_mrp_productions
 *
 * @package App\Models
 */
class LlxMrpMo extends Model
{
	protected $table = 'llx_mrp_mo';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'mrptype' => 'int',
		'qty' => 'float',
		'fk_warehouse' => 'int',
		'fk_soc' => 'int',
		'date_creation' => 'datetime',
		'date_valid' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'status' => 'int',
		'fk_product' => 'int',
		'date_start_planned' => 'datetime',
		'date_end_planned' => 'datetime',
		'fk_bom' => 'int',
		'fk_project' => 'int',
		'fk_parent_line' => 'int'
	];

	protected $fillable = [
		'entity',
		'ref',
		'mrptype',
		'label',
		'qty',
		'fk_warehouse',
		'fk_soc',
		'note_public',
		'note_private',
		'date_creation',
		'date_valid',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'fk_user_valid',
		'import_key',
		'model_pdf',
		'status',
		'fk_product',
		'date_start_planned',
		'date_end_planned',
		'fk_bom',
		'fk_project',
		'last_main_doc',
		'fk_parent_line'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}

	public function llx_mrp_productions()
	{
		return $this->hasMany(LlxMrpProduction::class, 'fk_mo');
	}
}
