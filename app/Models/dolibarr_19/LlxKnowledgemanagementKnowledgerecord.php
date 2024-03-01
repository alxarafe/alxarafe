<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxKnowledgemanagementKnowledgerecord
 *
 * @property int $rowid
 * @property int $entity
 * @property string $ref
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property string|null $last_main_doc
 * @property string|null $lang
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property string|null $import_key
 * @property string|null $model_pdf
 * @property string $question
 * @property string|null $answer
 * @property string|null $url
 * @property int|null $fk_ticket
 * @property int|null $fk_c_ticket_category
 * @property int $status
 *
 * @property LlxUser $llx_user
 * @property Collection|LlxCategorieKnowledgemanagement[] $llx_categorie_knowledgemanagements
 *
 * @package App\Models
 */
class LlxKnowledgemanagementKnowledgerecord extends Model
{
	protected $table = 'llx_knowledgemanagement_knowledgerecord';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_ticket' => 'int',
		'fk_c_ticket_category' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'entity',
		'ref',
		'date_creation',
		'tms',
		'last_main_doc',
		'lang',
		'fk_user_creat',
		'fk_user_modif',
		'fk_user_valid',
		'import_key',
		'model_pdf',
		'question',
		'answer',
		'url',
		'fk_ticket',
		'fk_c_ticket_category',
		'status'
	];

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_creat');
	}

	public function llx_categorie_knowledgemanagements()
	{
		return $this->hasMany(LlxCategorieKnowledgemanagement::class, 'fk_knowledgemanagement');
	}
}
