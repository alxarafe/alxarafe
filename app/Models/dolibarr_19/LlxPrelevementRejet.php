<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPrelevementRejet
 *
 * @property int $rowid
 * @property int|null $fk_prelevement_lignes
 * @property Carbon|null $date_rejet
 * @property int|null $motif
 * @property Carbon|null $date_creation
 * @property int|null $fk_user_creation
 * @property string|null $note
 * @property int|null $afacturer
 * @property int|null $fk_facture
 *
 * @package App\Models
 */
class LlxPrelevementRejet extends Model
{
	protected $table = 'llx_prelevement_rejet';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_prelevement_lignes' => 'int',
		'date_rejet' => 'datetime',
		'motif' => 'int',
		'date_creation' => 'datetime',
		'fk_user_creation' => 'int',
		'afacturer' => 'int',
		'fk_facture' => 'int'
	];

	protected $fillable = [
		'fk_prelevement_lignes',
		'date_rejet',
		'motif',
		'date_creation',
		'fk_user_creation',
		'note',
		'afacturer',
		'fk_facture'
	];
}
