<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxBomBom
 *
 * @property int $rowid
 * @property int $entity
 * @property string $ref
 * @property int|null $bomtype
 * @property string|null $label
 * @property int|null $fk_product
 * @property string|null $description
 * @property string|null $note_public
 * @property string|null $note_private
 * @property int|null $fk_warehouse
 * @property float|null $qty
 * @property float|null $efficiency
 * @property float|null $duration
 * @property Carbon $date_creation
 * @property Carbon|null $date_valid
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property string|null $import_key
 * @property string|null $model_pdf
 * @property int $status
 *
 * @property LlxUser $llx_user
 * @property Collection|LlxBomBomline[] $llx_bom_bomlines
 *
 * @package App\Models
 */
class LlxBomBom extends Model
{
	protected $table = 'llx_bom_bom';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'bomtype' => 'int',
		'fk_product' => 'int',
		'fk_warehouse' => 'int',
		'qty' => 'float',
		'efficiency' => 'float',
		'duration' => 'float',
		'date_creation' => 'datetime',
		'date_valid' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'entity',
		'ref',
		'bomtype',
		'label',
		'fk_product',
		'description',
		'note_public',
		'note_private',
		'fk_warehouse',
		'qty',
		'efficiency',
		'duration',
		'date_creation',
		'date_valid',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'fk_user_valid',
		'import_key',
		'model_pdf',
		'status'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}

	public function llx_bom_bomlines()
	{
		return $this->hasMany(LlxBomBomline::class, 'fk_bom');
	}
}
