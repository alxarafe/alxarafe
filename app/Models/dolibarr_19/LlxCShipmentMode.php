<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCShipmentMode
 *
 * @property int $rowid
 * @property int $entity
 * @property Carbon|null $tms
 * @property string $code
 * @property string $libelle
 * @property string|null $description
 * @property string|null $tracking
 * @property int|null $active
 * @property string|null $module
 *
 * @property Collection|LlxExpedition[] $llx_expeditions
 * @property Collection|LlxReception[] $llx_receptions
 *
 * @package App\Models
 */
class LlxCShipmentMode extends Model
{
	protected $table = 'llx_c_shipment_mode';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'tms' => 'datetime',
		'active' => 'int'
	];

	protected $fillable = [
		'entity',
		'tms',
		'code',
		'libelle',
		'description',
		'tracking',
		'active',
		'module'
	];

	public function llx_expeditions()
	{
		return $this->hasMany(LlxExpedition::class, 'fk_shipping_method');
	}

	public function llx_receptions()
	{
		return $this->hasMany(LlxReception::class, 'fk_shipping_method');
	}
}
