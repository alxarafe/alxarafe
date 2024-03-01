<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFichinter
 *
 * @property int $rowid
 * @property int $fk_soc
 * @property int|null $fk_projet
 * @property int|null $fk_contrat
 * @property string $ref
 * @property string|null $ref_ext
 * @property string|null $ref_client
 * @property int $entity
 * @property Carbon|null $tms
 * @property Carbon|null $datec
 * @property Carbon|null $date_valid
 * @property Carbon|null $datei
 * @property int|null $fk_user_author
 * @property int|null $fk_user_modif
 * @property int|null $fk_user_valid
 * @property int|null $fk_statut
 * @property Carbon|null $dateo
 * @property Carbon|null $datee
 * @property Carbon|null $datet
 * @property float|null $duree
 * @property string|null $description
 * @property string|null $note_private
 * @property string|null $note_public
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property string|null $import_key
 * @property string|null $extraparams
 *
 * @property LlxSociete $llx_societe
 * @property Collection|LlxFichinterdet[] $llx_fichinterdets
 *
 * @package App\Models
 */
class LlxFichinter extends Model
{
	protected $table = 'llx_fichinter';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_soc' => 'int',
		'fk_projet' => 'int',
		'fk_contrat' => 'int',
		'entity' => 'int',
		'tms' => 'datetime',
		'datec' => 'datetime',
		'date_valid' => 'datetime',
		'datei' => 'datetime',
		'fk_user_author' => 'int',
		'fk_user_modif' => 'int',
		'fk_user_valid' => 'int',
		'fk_statut' => 'int',
		'dateo' => 'datetime',
		'datee' => 'datetime',
		'datet' => 'datetime',
		'duree' => 'float'
	];

	protected $fillable = [
		'fk_soc',
		'fk_projet',
		'fk_contrat',
		'ref',
		'ref_ext',
		'ref_client',
		'entity',
		'tms',
		'datec',
		'date_valid',
		'datei',
		'fk_user_author',
		'fk_user_modif',
		'fk_user_valid',
		'fk_statut',
		'dateo',
		'datee',
		'datet',
		'duree',
		'description',
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

	public function llx_fichinterdets()
	{
		return $this->hasMany(LlxFichinterdet::class, 'fk_fichinter');
	}
}
