<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCommandeFournisseurLog
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property Carbon $datelog
 * @property int $fk_commande
 * @property int $fk_statut
 * @property int $fk_user
 * @property string|null $comment
 *
 * @package App\Models
 */
class LlxCommandeFournisseurLog extends Model
{
	protected $table = 'llx_commande_fournisseur_log';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'datelog' => 'datetime',
		'fk_commande' => 'int',
		'fk_statut' => 'int',
		'fk_user' => 'int'
	];

	protected $fillable = [
		'tms',
		'datelog',
		'fk_commande',
		'fk_statut',
		'fk_user',
		'comment'
	];
}
