<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorieKnowledgemanagement
 *
 * @property int $fk_categorie
 * @property int $fk_knowledgemanagement
 * @property string|null $import_key
 *
 * @property LlxCategorie $llx_categorie
 * @property LlxKnowledgemanagementKnowledgerecord $llx_knowledgemanagement_knowledgerecord
 *
 * @package App\Models
 */
class LlxCategorieKnowledgemanagement extends Model
{
	protected $table = 'llx_categorie_knowledgemanagement';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'fk_categorie' => 'int',
		'fk_knowledgemanagement' => 'int'
	];

	protected $fillable = [
		'import_key'
	];

	public function llx_categorie()
	{
		return $this->belongsTo(LlxCategorie::class, 'fk_categorie');
	}

	public function llx_knowledgemanagement_knowledgerecord()
	{
		return $this->belongsTo(LlxKnowledgemanagementKnowledgerecord::class, 'fk_knowledgemanagement');
	}
}
