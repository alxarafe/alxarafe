<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxTicket
 *
 * @property int $rowid
 * @property int|null $entity
 * @property string $ref
 * @property string $track_id
 * @property int|null $fk_soc
 * @property int|null $fk_project
 * @property int|null $fk_contract
 * @property string|null $origin_email
 * @property int|null $fk_user_create
 * @property int|null $fk_user_assign
 * @property string|null $subject
 * @property string|null $message
 * @property int|null $fk_statut
 * @property int|null $resolution
 * @property int|null $progress
 * @property string|null $timing
 * @property string|null $type_code
 * @property string|null $category_code
 * @property string|null $severity_code
 * @property Carbon|null $datec
 * @property Carbon|null $date_read
 * @property Carbon|null $date_last_msg_sent
 * @property Carbon|null $date_close
 * @property int|null $notify_tiers_at_create
 * @property string|null $email_msgid
 * @property Carbon|null $email_date
 * @property string|null $ip
 * @property Carbon|null $tms
 * @property string|null $import_key
 *
 * @property Collection|LlxCategorieTicket[] $llx_categorie_tickets
 *
 * @package App\Models
 */
class LlxTicket extends Model
{
	protected $table = 'llx_ticket';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_soc' => 'int',
		'fk_project' => 'int',
		'fk_contract' => 'int',
		'fk_user_create' => 'int',
		'fk_user_assign' => 'int',
		'fk_statut' => 'int',
		'resolution' => 'int',
		'progress' => 'int',
		'datec' => 'datetime',
		'date_read' => 'datetime',
		'date_last_msg_sent' => 'datetime',
		'date_close' => 'datetime',
		'notify_tiers_at_create' => 'int',
		'email_date' => 'datetime',
		'tms' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'ref',
		'track_id',
		'fk_soc',
		'fk_project',
		'fk_contract',
		'origin_email',
		'fk_user_create',
		'fk_user_assign',
		'subject',
		'message',
		'fk_statut',
		'resolution',
		'progress',
		'timing',
		'type_code',
		'category_code',
		'severity_code',
		'datec',
		'date_read',
		'date_last_msg_sent',
		'date_close',
		'notify_tiers_at_create',
		'email_msgid',
		'email_date',
		'ip',
		'tms',
		'import_key'
	];

	public function llx_categorie_tickets()
	{
		return $this->hasMany(LlxCategorieTicket::class, 'fk_ticket');
	}
}
