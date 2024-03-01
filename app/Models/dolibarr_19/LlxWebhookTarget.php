<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxWebhookTarget
 *
 * @property int $rowid
 * @property string $ref
 * @property string|null $label
 * @property string|null $description
 * @property string|null $note_public
 * @property string|null $note_private
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $import_key
 * @property int $status
 * @property string $url
 * @property string|null $connection_method
 * @property string|null $connection_data
 * @property string|null $trigger_codes
 *
 * @property LlxUser $llx_user
 *
 * @package App\Models
 */
class LlxWebhookTarget extends Model
{
	protected $table = 'llx_webhook_target';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'ref',
		'label',
		'description',
		'note_public',
		'note_private',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'import_key',
		'status',
		'url',
		'connection_method',
		'connection_data',
		'trigger_codes'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}
}
