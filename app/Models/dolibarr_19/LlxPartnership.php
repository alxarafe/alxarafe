<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPartnership
 *
 * @property int $rowid
 * @property int $entity
 * @property string $ref
 * @property int $status
 * @property int $fk_type
 * @property int|null $fk_soc
 * @property int|null $fk_member
 * @property string|null $email_partnership
 * @property Carbon $date_partnership_start
 * @property Carbon|null $date_partnership_end
 * @property string|null $reason_decline_or_cancel
 * @property Carbon $date_creation
 * @property int|null $fk_user_creat
 * @property Carbon|null $tms
 * @property int|null $fk_user_modif
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $last_main_doc
 * @property string|null $url_to_check
 * @property int|null $count_last_url_check_error
 * @property Carbon|null $last_check_backlink
 * @property string|null $ip
 * @property string|null $import_key
 * @property string|null $model_pdf
 *
 * @package App\Models
 */
class LlxPartnership extends Model
{
	protected $table = 'llx_partnership';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'status' => 'int',
		'fk_type' => 'int',
		'fk_soc' => 'int',
		'fk_member' => 'int',
		'date_partnership_start' => 'datetime',
		'date_partnership_end' => 'datetime',
		'date_creation' => 'datetime',
		'fk_user_creat' => 'int',
		'tms' => 'datetime',
		'fk_user_modif' => 'int',
		'count_last_url_check_error' => 'int',
		'last_check_backlink' => 'datetime'
	];

	protected $fillable = [
		'entity',
		'ref',
		'status',
		'fk_type',
		'fk_soc',
		'fk_member',
		'email_partnership',
		'date_partnership_start',
		'date_partnership_end',
		'reason_decline_or_cancel',
		'date_creation',
		'fk_user_creat',
		'tms',
		'fk_user_modif',
		'note_private',
		'note_public',
		'last_main_doc',
		'url_to_check',
		'count_last_url_check_error',
		'last_check_backlink',
		'ip',
		'import_key',
		'model_pdf'
	];
}
