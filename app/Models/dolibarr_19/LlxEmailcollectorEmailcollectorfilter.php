<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxEmailcollectorEmailcollectorfilter
 *
 * @property int $rowid
 * @property int $fk_emailcollector
 * @property string $type
 * @property string|null $rulevalue
 * @property Carbon $date_creation
 * @property Carbon|null $tms
 * @property int $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $import_key
 * @property int $status
 *
 * @property LlxEmailcollectorEmailcollector $llx_emailcollector_emailcollector
 *
 * @package App\Models
 */
class LlxEmailcollectorEmailcollectorfilter extends Model
{
	protected $table = 'llx_emailcollector_emailcollectorfilter';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'fk_emailcollector' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'fk_emailcollector',
		'type',
		'rulevalue',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'import_key',
		'status'
	];

	public function llx_emailcollector_emailcollector()
	{
		return $this->belongsTo(LlxEmailcollectorEmailcollector::class, 'fk_emailcollector');
	}
}
