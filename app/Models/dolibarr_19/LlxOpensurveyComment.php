<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxOpensurveyComment
 *
 * @property int $id_comment
 * @property string $id_sondage
 * @property string $comment
 * @property Carbon|null $tms
 * @property string|null $usercomment
 * @property Carbon $date_creation
 * @property string|null $ip
 *
 * @package App\Models
 */
class LlxOpensurveyComment extends Model
{
	protected $table = 'llx_opensurvey_comments';
	protected $primaryKey = 'id_comment';
	public $timestamps = false;

	protected $casts = [
		'tms' => 'datetime',
		'date_creation' => 'datetime'
	];

	protected $fillable = [
		'id_sondage',
		'comment',
		'tms',
		'usercomment',
		'date_creation',
		'ip'
	];
}
