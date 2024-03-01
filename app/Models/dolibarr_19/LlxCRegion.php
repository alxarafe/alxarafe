<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCRegion
 *
 * @property int $rowid
 * @property int $code_region
 * @property int $fk_pays
 * @property string|null $cheflieu
 * @property int|null $tncc
 * @property string|null $nom
 * @property int $active
 *
 * @property LlxCCountry $llx_c_country
 * @property Collection|LlxCDepartement[] $llx_c_departements
 *
 * @package App\Models
 */
class LlxCRegion extends Model
{
	protected $table = 'llx_c_regions';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'code_region' => 'int',
		'fk_pays' => 'int',
		'tncc' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code_region',
		'fk_pays',
		'cheflieu',
		'tncc',
		'nom',
		'active'
	];

	public function llx_c_country()
	{
		return $this->belongsTo(LlxCCountry::class, 'fk_pays');
	}

	public function llx_c_departements()
	{
		return $this->hasMany(LlxCDepartement::class, 'fk_region', 'code_region');
	}
}
