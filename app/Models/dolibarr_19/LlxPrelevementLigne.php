<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPrelevementLigne
 *
 * @property int $rowid
 * @property int|null $fk_prelevement_bons
 * @property int $fk_soc
 * @property int|null $fk_user
 * @property int|null $statut
 * @property string|null $client_nom
 * @property float|null $amount
 * @property string|null $code_banque
 * @property string|null $code_guichet
 * @property string|null $number
 * @property string|null $cle_rib
 * @property string|null $note
 * @property Carbon|null $tms
 *
 * @property LlxPrelevementBon|null $llx_prelevement_bon
 * @property Collection|LlxPrelevement[] $llx_prelevements
 *
 * @package App\Models
 */
class LlxPrelevementLigne extends Model
{
	protected $table = 'llx_prelevement_lignes';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_prelevement_bons' => 'int',
		'fk_soc' => 'int',
		'fk_user' => 'int',
		'statut' => 'int',
		'amount' => 'float',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'fk_prelevement_bons',
		'fk_soc',
		'fk_user',
		'statut',
		'client_nom',
		'amount',
		'code_banque',
		'code_guichet',
		'number',
		'cle_rib',
		'note',
		'tms'
	];

	public function llx_prelevement_bon()
	{
		return $this->belongsTo(LlxPrelevementBon::class, 'fk_prelevement_bons');
	}

	public function llx_prelevements()
	{
		return $this->hasMany(LlxPrelevement::class, 'fk_prelevement_lignes');
	}
}
