<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxOpensurveyFormquestion
 *
 * @property int $rowid
 * @property string|null $id_sondage
 * @property string|null $question
 * @property string|null $available_answers
 *
 * @package App\Models
 */
class LlxOpensurveyFormquestion extends Model
{
	protected $table = 'llx_opensurvey_formquestions';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $fillable = [
		'id_sondage',
		'question',
		'available_answers'
	];
}
