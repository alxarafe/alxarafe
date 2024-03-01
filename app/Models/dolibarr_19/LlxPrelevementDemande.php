<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPrelevementDemande
 *
 * @property int $rowid
 * @property int $entity
 * @property int|null $fk_facture
 * @property int|null $fk_facture_fourn
 * @property int|null $fk_salary
 * @property string|null $sourcetype
 * @property float $amount
 * @property Carbon $date_demande
 * @property int|null $traite
 * @property Carbon|null $date_traite
 * @property int|null $fk_prelevement_bons
 * @property int $fk_user_demande
 * @property string|null $code_banque
 * @property string|null $code_guichet
 * @property string|null $number
 * @property string|null $cle_rib
 * @property string|null $type
 * @property string|null $ext_payment_id
 * @property string|null $ext_payment_site
 *
 * @package App\Models
 */
class LlxPrelevementDemande extends Model
{
	protected $table = 'llx_prelevement_demande';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_facture' => 'int',
		'fk_facture_fourn' => 'int',
		'fk_salary' => 'int',
		'amount' => 'float',
		'date_demande' => 'datetime',
		'traite' => 'int',
		'date_traite' => 'datetime',
		'fk_prelevement_bons' => 'int',
		'fk_user_demande' => 'int'
	];

	protected $fillable = [
		'entity',
		'fk_facture',
		'fk_facture_fourn',
		'fk_salary',
		'sourcetype',
		'amount',
		'date_demande',
		'traite',
		'date_traite',
		'fk_prelevement_bons',
		'fk_user_demande',
		'code_banque',
		'code_guichet',
		'number',
		'cle_rib',
		'type',
		'ext_payment_id',
		'ext_payment_site'
	];
}
