<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCDepartement
 *
 * @property int $rowid
 * @property string $code_departement
 * @property int|null $fk_region
 * @property string|null $cheflieu
 * @property int|null $tncc
 * @property string|null $ncc
 * @property string|null $nom
 * @property int $active
 *
 * @property LlxCRegion|null $llx_c_region
 * @property Collection|LlxCZiptown[] $llx_c_ziptowns
 *
 * @package App\Models
 */
class LlxCDepartement extends Model
{
	protected $table = 'llx_c_departements';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_region' => 'int',
		'tncc' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code_departement',
		'fk_region',
		'cheflieu',
		'tncc',
		'ncc',
		'nom',
		'active'
	];

	public function llx_c_region()
	{
		return $this->belongsTo(LlxCRegion::class, 'fk_region', 'code_region');
	}

	public function llx_c_ziptowns()
	{
		return $this->hasMany(LlxCZiptown::class, 'fk_county');
	}
}
