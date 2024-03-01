<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxExpeditiondet
 *
 * @property int $rowid
 * @property int $fk_expedition
 * @property int|null $fk_origin_line
 * @property int|null $fk_entrepot
 * @property float|null $qty
 * @property int|null $rang
 *
 * @property LlxExpedition $llx_expedition
 * @property Collection|LlxExpeditiondetBatch[] $llx_expeditiondet_batches
 *
 * @package App\Models
 */
class LlxExpeditiondet extends Model
{
	protected $table = 'llx_expeditiondet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_expedition' => 'int',
		'fk_origin_line' => 'int',
		'fk_entrepot' => 'int',
		'qty' => 'float',
		'rang' => 'int'
	];

	protected $fillable = [
		'fk_expedition',
		'fk_origin_line',
		'fk_entrepot',
		'qty',
		'rang'
	];

	public function llx_expedition()
	{
		return $this->belongsTo(LlxExpedition::class, 'fk_expedition');
	}

	public function llx_expeditiondet_batches()
	{
		return $this->hasMany(LlxExpeditiondetBatch::class, 'fk_expeditiondet');
	}
}
