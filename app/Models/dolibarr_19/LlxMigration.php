<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxMigration
 *
 * @property int $id
 * @property string $migration
 * @property int $batch
 *
 * @package App\Models
 */
class LlxMigration extends Model
{
	protected $table = 'llx_migrations';
	public $timestamps = false;

	protected $casts = [
		'batch' => 'int'
	];

	protected $fillable = [
		'migration',
		'batch'
	];
}
