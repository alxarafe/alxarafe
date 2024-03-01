<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxDeliverydet
 *
 * @property int $rowid
 * @property int|null $fk_delivery
 * @property int|null $fk_origin_line
 * @property int|null $fk_product
 * @property string|null $description
 * @property float|null $qty
 * @property float|null $subprice
 * @property float|null $total_ht
 * @property int|null $rang
 *
 * @property LlxDelivery|null $llx_delivery
 *
 * @package App\Models
 */
class LlxDeliverydet extends Model
{
	protected $table = 'llx_deliverydet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_delivery' => 'int',
		'fk_origin_line' => 'int',
		'fk_product' => 'int',
		'qty' => 'float',
		'subprice' => 'float',
		'total_ht' => 'float',
		'rang' => 'int'
	];

	protected $fillable = [
		'fk_delivery',
		'fk_origin_line',
		'fk_product',
		'description',
		'qty',
		'subprice',
		'total_ht',
		'rang'
	];

	public function llx_delivery()
	{
		return $this->belongsTo(LlxDelivery::class, 'fk_delivery');
	}
}
