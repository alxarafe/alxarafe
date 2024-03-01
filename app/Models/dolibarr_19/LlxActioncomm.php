<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxActioncomm
 *
 * @property int $id
 * @property string $ref
 * @property string|null $ref_ext
 * @property int $entity
 * @property Carbon|null $datep
 * @property Carbon|null $datep2
 * @property int|null $fk_action
 * @property string|null $code
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int|null $fk_user_author
 * @property int|null $fk_user_mod
 * @property int|null $fk_project
 * @property int|null $fk_soc
 * @property int|null $fk_contact
 * @property int $fk_parent
 * @property int|null $fk_user_action
 * @property int|null $fk_user_done
 * @property int|null $transparency
 * @property int|null $priority
 * @property string|null $visibility
 * @property int $fulldayevent
 * @property int $percent
 * @property string|null $location
 * @property float|null $durationp
 * @property string $label
 * @property string|null $note
 * @property int|null $calling_duration
 * @property string|null $email_subject
 * @property string|null $email_msgid
 * @property string|null $email_from
 * @property string|null $email_sender
 * @property string|null $email_to
 * @property string|null $email_tocc
 * @property string|null $email_tobcc
 * @property string|null $errors_to
 * @property string|null $reply_to
 * @property string|null $recurid
 * @property string|null $recurrule
 * @property Carbon|null $recurdateend
 * @property int|null $num_vote
 * @property int $event_paid
 * @property int $status
 * @property int|null $fk_element
 * @property string|null $elementtype
 * @property string|null $ip
 * @property int|null $fk_bookcal_calendar
 * @property string|null $import_key
 * @property string|null $extraparams
 *
 * @property Collection|LlxCategorieActioncomm[] $llx_categorie_actioncomms
 *
 * @package App\Models
 */
class LlxActioncomm extends Model
{
	protected $table = 'llx_actioncomm';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'datep' => 'datetime',
		'datep2' => 'datetime',
		'fk_action' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_mod' => 'int',
		'fk_project' => 'int',
		'fk_soc' => 'int',
		'fk_contact' => 'int',
		'fk_parent' => 'int',
		'fk_user_action' => 'int',
		'fk_user_done' => 'int',
		'transparency' => 'int',
		'priority' => 'int',
		'fulldayevent' => 'int',
		'percent' => 'int',
		'durationp' => 'float',
		'calling_duration' => 'int',
		'recurdateend' => 'datetime',
		'num_vote' => 'int',
		'event_paid' => 'int',
		'status' => 'int',
		'fk_element' => 'int',
		'fk_bookcal_calendar' => 'int'
	];

	protected $fillable = [
		'ref',
		'ref_ext',
		'entity',
		'datep',
		'datep2',
		'fk_action',
		'code',
		'datec',
		'tms',
		'fk_user_author',
		'fk_user_mod',
		'fk_project',
		'fk_soc',
		'fk_contact',
		'fk_parent',
		'fk_user_action',
		'fk_user_done',
		'transparency',
		'priority',
		'visibility',
		'fulldayevent',
		'percent',
		'location',
		'durationp',
		'label',
		'note',
		'calling_duration',
		'email_subject',
		'email_msgid',
		'email_from',
		'email_sender',
		'email_to',
		'email_tocc',
		'email_tobcc',
		'errors_to',
		'reply_to',
		'recurid',
		'recurrule',
		'recurdateend',
		'num_vote',
		'event_paid',
		'status',
		'fk_element',
		'elementtype',
		'ip',
		'fk_bookcal_calendar',
		'import_key',
		'extraparams'
	];

	public function llx_categorie_actioncomms()
	{
		return $this->hasMany(LlxCategorieActioncomm::class, 'fk_actioncomm');
	}
}
