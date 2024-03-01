<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCHrmPublicHoliday
 *
 * @property int $id
 * @property int $entity
 * @property int|null $fk_country
 * @property int|null $fk_departement
 * @property string|null $code
 * @property string|null $dayrule
 * @property int|null $day
 * @property int|null $month
 * @property int|null $year
 * @property int|null $active
 * @property string|null $import_key
 *
 * @package App\Models
 */
class LlxCHrmPublicHoliday extends Model
{
	protected $table = 'llx_c_hrm_public_holiday';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_country' => 'int',
		'fk_departement' => 'int',
		'day' => 'int',
		'month' => 'int',
		'year' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'entity',
		'fk_country',
		'fk_departement',
		'code',
		'dayrule',
		'day',
		'month',
		'year',
		'active',
		'import_key'
	];
}
