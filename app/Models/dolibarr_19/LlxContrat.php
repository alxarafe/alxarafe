<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxContrat
 *
 * @property int $rowid
 * @property string|null $ref
 * @property string|null $ref_customer
 * @property string|null $ref_supplier
 * @property string|null $ref_ext
 * @property int $entity
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property Carbon|null $date_contrat
 * @property int|null $statut
 * @property Carbon|null $fin_validite
 * @property Carbon|null $date_cloture
 * @property int $fk_soc
 * @property int|null $fk_projet
 * @property int|null $fk_commercial_signature
 * @property int|null $fk_commercial_suivi
 * @property int $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_cloture
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property string|null $import_key
 * @property string|null $extraparams
 *
 * @property LlxSociete $llx_societe
 * @property LlxUser $llx_user
 * @property Collection|LlxContratdet[] $llx_contratdets
 *
 * @package App\Models
 */
class LlxContrat extends Model
{
	protected $table = 'llx_contrat';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'tms' => 'datetime',
		'datec' => 'datetime',
		'date_contrat' => 'datetime',
		'statut' => 'int',
		'fin_validite' => 'datetime',
		'date_cloture' => 'datetime',
		'fk_soc' => 'int',
		'fk_projet' => 'int',
		'fk_commercial_signature' => 'int',
		'fk_commercial_suivi' => 'int',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_cloture' => 'int'
	];

	protected $fillable = [
		'ref',
		'ref_customer',
		'ref_supplier',
		'ref_ext',
		'entity',
		'tms',
		'datec',
		'date_contrat',
		'statut',
		'fin_validite',
		'date_cloture',
		'fk_soc',
		'fk_projet',
		'fk_commercial_signature',
		'fk_commercial_suivi',
		'fk_user_author',
		'fk_user_modif',
		'fk_user_cloture',
		'note_private',
		'note_public',
		'model_pdf',
		'last_main_doc',
		'import_key',
		'extraparams'
	];

	public function llx_societe()
	{
		return $this->belongsTo(LlxSociete::class, 'fk_soc');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_author');
	}

	public function llx_contratdets()
	{
		return $this->hasMany(LlxContratdet::class, 'fk_contrat');
	}
}
