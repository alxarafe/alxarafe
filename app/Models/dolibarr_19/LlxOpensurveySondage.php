<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxOpensurveySondage
 *
 * @property string $id_sondage
 * @property int $entity
 * @property string|null $commentaires
 * @property string|null $mail_admin
 * @property string|null $nom_admin
 * @property int $fk_user_creat
 * @property string $titre
 * @property Carbon|null $date_fin
 * @property int|null $status
 * @property string $format
 * @property int $mailsonde
 * @property int $allow_comments
 * @property int $allow_spy
 * @property Carbon|null $tms
 * @property string|null $sujet
 *
 * @package App\Models
 */
class LlxOpensurveySondage extends Model
{
	protected $table = 'llx_opensurvey_sondage';
	protected $primaryKey = 'id_sondage';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_user_creat' => 'int',
		'date_fin' => 'datetime',
		'status' => 'int',
		'mailsonde' => 'int',
		'allow_comments' => 'int',
		'allow_spy' => 'int',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'commentaires',
		'mail_admin',
		'nom_admin',
		'fk_user_creat',
		'titre',
		'date_fin',
		'status',
		'format',
		'mailsonde',
		'allow_comments',
		'allow_spy',
		'tms',
		'sujet'
	];
}
