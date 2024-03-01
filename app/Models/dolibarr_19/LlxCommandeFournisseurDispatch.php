<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCommandeFournisseurDispatch
 *
 * @property int $rowid
 * @property int|null $fk_product
 * @property int|null $fk_commande
 * @property int|null $fk_commandefourndet
 * @property string $element_type
 * @property int|null $fk_projet
 * @property int|null $fk_reception
 * @property float|null $qty
 * @property int|null $fk_entrepot
 * @property string|null $comment
 * @property string|null $batch
 * @property Carbon|null $eatby
 * @property Carbon|null $sellby
 * @property int|null $status
 * @property int|null $fk_user
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property float|null $cost_price
 *
 * @property LlxReception|null $llx_reception
 *
 * @package App\Models
 */
class LlxCommandeFournisseurDispatch extends Model
{
	protected $table = 'llx_commande_fournisseur_dispatch';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_product' => 'int',
		'fk_commande' => 'int',
		'fk_commandefourndet' => 'int',
		'fk_projet' => 'int',
		'fk_reception' => 'int',
		'qty' => 'float',
		'fk_entrepot' => 'int',
		'eatby' => 'datetime',
		'sellby' => 'datetime',
		'status' => 'int',
		'fk_user' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'cost_price' => 'float'
	];

	protected $fillable = [
		'fk_product',
		'fk_commande',
		'fk_commandefourndet',
		'element_type',
		'fk_projet',
		'fk_reception',
		'qty',
		'fk_entrepot',
		'comment',
		'batch',
		'eatby',
		'sellby',
		'status',
		'fk_user',
		'datec',
		'tms',
		'cost_price'
	];

	public function llx_reception()
	{
		return $this->belongsTo(LlxReception::class, 'fk_reception');
	}
}
