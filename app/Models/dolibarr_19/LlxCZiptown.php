<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCZiptown
 *
 * @property int $rowid
 * @property string|null $code
 * @property int|null $fk_county
 * @property int $fk_pays
 * @property string $zip
 * @property string $town
 * @property string|null $town_up
 * @property int $active
 *
 * @property LlxCDepartement|null $llx_c_departement
 * @property LlxCCountry $llx_c_country
 *
 * @package App\Models
 */
class LlxCZiptown extends Model
{
	protected $table = 'llx_c_ziptown';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_county' => 'int',
		'fk_pays' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'code',
		'fk_county',
		'fk_pays',
		'zip',
		'town',
		'town_up',
		'active'
	];

	public function llx_c_departement()
	{
		return $this->belongsTo(LlxCDepartement::class, 'fk_county');
	}

	public function llx_c_country()
	{
		return $this->belongsTo(LlxCCountry::class, 'fk_pays');
	}
}
