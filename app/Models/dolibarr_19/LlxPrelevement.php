<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxPrelevement
 *
 * @property int $rowid
 * @property int|null $fk_facture
 * @property int|null $fk_facture_fourn
 * @property int|null $fk_salary
 * @property int $fk_prelevement_lignes
 *
 * @property LlxPrelevementLigne $llx_prelevement_ligne
 *
 * @package App\Models
 */
class LlxPrelevement extends Model
{
	protected $table = 'llx_prelevement';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_facture' => 'int',
		'fk_facture_fourn' => 'int',
		'fk_salary' => 'int',
		'fk_prelevement_lignes' => 'int'
	];

	protected $fillable = [
		'fk_facture',
		'fk_facture_fourn',
		'fk_salary',
		'fk_prelevement_lignes'
	];

	public function llx_prelevement_ligne()
	{
		return $this->belongsTo(LlxPrelevementLigne::class, 'fk_prelevement_lignes');
	}
}
