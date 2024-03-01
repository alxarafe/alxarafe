<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxOpensurveyUserStud
 *
 * @property int $id_users
 * @property string $nom
 * @property string $id_sondage
 * @property string $reponses
 * @property Carbon|null $tms
 * @property Carbon $date_creation
 * @property string|null $ip
 *
 * @package App\Models
 */
class LlxOpensurveyUserStud extends Model
{
	protected $table = 'llx_opensurvey_user_studs';
	protected $primaryKey = 'id_users';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'date_creation' => 'datetime'
	];

	protected $fillable = [
		'nom',
		'id_sondage',
		'reponses',
		'tms',
		'date_creation',
		'ip'
	];
}
