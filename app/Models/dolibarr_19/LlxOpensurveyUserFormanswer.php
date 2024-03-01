<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxOpensurveyUserFormanswer
 *
 * @property int $fk_user_survey
 * @property int $fk_question
 * @property string|null $reponses
 *
 * @package App\Models
 */
class LlxOpensurveyUserFormanswer extends Model
{
	protected $table = 'llx_opensurvey_user_formanswers';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_user_survey' => 'int',
		'fk_question' => 'int'
	];

	protected $fillable = [
		'fk_user_survey',
		'fk_question',
		'reponses'
	];
}
