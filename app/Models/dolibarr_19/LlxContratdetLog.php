<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxContratdetLog
 *
 * @property int $rowid
 * @property Carbon|null $tms
 * @property int $fk_contratdet
 * @property Carbon $date
 * @property int $statut
 * @property int $fk_user_author
 * @property string|null $commentaire
 *
 * @property LlxContratdet $llx_contratdet
 *
 * @package App\Models
 */
class LlxContratdetLog extends Model
{
	protected $table = 'llx_contratdet_log';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'fk_contratdet' => 'int',
		'date' => 'datetime',
		'statut' => 'int',
		'fk_user_author' => 'int'
	];

	protected $fillable = [
		'tms',
		'fk_contratdet',
		'date',
		'statut',
		'fk_user_author',
		'commentaire'
	];

	public function llx_contratdet()
	{
		return $this->belongsTo(LlxContratdet::class, 'fk_contratdet');
	}
}
