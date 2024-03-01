<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxEventorganizationConferenceorboothattendee
 *
 * @property int $rowid
 * @property string $ref
 * @property int|null $fk_soc
 * @property int|null $fk_actioncomm
 * @property int $fk_project
 * @property int|null $fk_invoice
 * @property string|null $email
 * @property string|null $email_company
 * @property string|null $firstname
 * @property string|null $lastname
 * @property Carbon|null $date_subscription
 * @property float|null $amount
 * @property string|null $note_public
 * @property string|null $note_private
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $last_main_doc
 * @property string|null $ip
 * @property string|null $import_key
 * @property string|null $model_pdf
 * @property int $status
 *
 * @package App\Models
 */
class LlxEventorganizationConferenceorboothattendee extends Model
{
	protected $table = 'llx_eventorganization_conferenceorboothattendee';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_soc' => 'int',
		'fk_actioncomm' => 'int',
		'fk_project' => 'int',
		'fk_invoice' => 'int',
		'date_subscription' => 'datetime',
		'amount' => 'float',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'ref',
		'fk_soc',
		'fk_actioncomm',
		'fk_project',
		'fk_invoice',
		'email',
		'email_company',
		'firstname',
		'lastname',
		'date_subscription',
		'amount',
		'note_public',
		'note_private',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'last_main_doc',
		'ip',
		'import_key',
		'model_pdf',
		'status'
	];
}
