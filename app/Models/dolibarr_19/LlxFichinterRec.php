<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxFichinterRec
 *
 * @property int $rowid
 * @property string $titre
 * @property int $entity
 * @property int|null $fk_soc
 * @property Carbon|null $datec
 * @property int|null $fk_contrat
 * @property int|null $fk_user_author
 * @property int|null $fk_projet
 * @property float|null $duree
 * @property string|null $description
 * @property string|null $modelpdf
 * @property string|null $note_private
 * @property string|null $note_public
 * @property int|null $frequency
 * @property string|null $unit_frequency
 * @property Carbon|null $date_when
 * @property Carbon|null $date_last_gen
 * @property int|null $nb_gen_done
 * @property int|null $nb_gen_max
 * @property int|null $auto_validate
 *
 * @property LlxProjet|null $llx_projet
 * @property LlxUser|null $llx_user
 *
 * @package App\Models
 */
class LlxFichinterRec extends Model
{
	protected $table = 'llx_fichinter_rec';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_soc' => 'int',
		'datec' => 'datetime',
		'fk_contrat' => 'int',
		'fk_user_author' => 'int',
		'fk_projet' => 'int',
		'duree' => 'float',
		'frequency' => 'int',
		'date_when' => 'datetime',
		'date_last_gen' => 'datetime',
		'nb_gen_done' => 'int',
		'nb_gen_max' => 'int',
		'auto_validate' => 'int'
	];

	protected $fillable = [
		'titre',
		'entity',
		'fk_soc',
		'datec',
		'fk_contrat',
		'fk_user_author',
		'fk_projet',
		'duree',
		'description',
		'modelpdf',
		'note_private',
		'note_public',
		'frequency',
		'unit_frequency',
		'date_when',
		'date_last_gen',
		'nb_gen_done',
		'nb_gen_max',
		'auto_validate'
	];

	public function llx_projet()
	{
		return $this->belongsTo(LlxProjet::class, 'fk_projet');
	}

	public function llx_user()
	{
		return $this->belongsTo(LlxUser::class, 'fk_user_author');
	}
}
