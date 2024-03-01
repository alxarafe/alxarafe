<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxMailingCible
 *
 * @property int $rowid
 * @property int $fk_mailing
 * @property int $fk_contact
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string $email
 * @property string|null $other
 * @property string|null $tag
 * @property int $statut
 * @property string|null $source_url
 * @property int|null $source_id
 * @property string|null $source_type
 * @property Carbon|null $date_envoi
 * @property Carbon|null $tms
 * @property string|null $error_text
 *
 * @package App\Models
 */
class LlxMailingCible extends Model
{
	protected $table = 'llx_mailing_cibles';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_mailing' => 'int',
		'fk_contact' => 'int',
		'statut' => 'int',
		'source_id' => 'int',
		'date_envoi' => 'datetime',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'fk_mailing',
		'fk_contact',
		'lastname',
		'firstname',
		'email',
		'other',
		'tag',
		'statut',
		'source_url',
		'source_id',
		'source_type',
		'date_envoi',
		'tms',
		'error_text'
	];
}
