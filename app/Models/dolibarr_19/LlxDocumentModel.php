<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxDocumentModel
 *
 * @property int $rowid
 * @property string|null $nom
 * @property int $entity
 * @property string $type
 * @property string|null $libelle
 * @property string|null $description
 *
 * @package App\Models
 */
class LlxDocumentModel extends Model
{
	protected $table = 'llx_document_model';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int'
	];

	protected $fillable = [
		'nom',
		'entity',
		'type',
		'libelle',
		'description'
	];
}
