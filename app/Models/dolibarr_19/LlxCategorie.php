<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxCategorie
 *
 * @property int $rowid
 * @property int $entity
 * @property int $fk_parent
 * @property string $label
 * @property string|null $ref_ext
 * @property int $type
 * @property string|null $description
 * @property string|null $color
 * @property int|null $fk_soc
 * @property int $visible
 * @property Carbon|null $date_creation
 * @property Carbon|null $tms
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string|null $import_key
 *
 * @property Collection|LlxCategorieAccount[] $llx_categorie_accounts
 * @property Collection|LlxCategorieActioncomm[] $llx_categorie_actioncomms
 * @property Collection|LlxCategorieContact[] $llx_categorie_contacts
 * @property Collection|LlxCategorieFournisseur[] $llx_categorie_fournisseurs
 * @property Collection|LlxCategorieKnowledgemanagement[] $llx_categorie_knowledgemanagements
 * @property Collection|LlxCategorieLang[] $llx_categorie_langs
 * @property Collection|LlxCategorieMember[] $llx_categorie_members
 * @property Collection|LlxCategorieProduct[] $llx_categorie_products
 * @property Collection|LlxCategorieProject[] $llx_categorie_projects
 * @property Collection|LlxCategorieSociete[] $llx_categorie_societes
 * @property Collection|LlxCategorieTicket[] $llx_categorie_tickets
 * @property Collection|LlxCategorieUser[] $llx_categorie_users
 * @property Collection|LlxCategorieWarehouse[] $llx_categorie_warehouses
 * @property Collection|LlxCategorieWebsitePage[] $llx_categorie_website_pages
 * @property Collection|LlxElementCategorie[] $llx_element_categories
 *
 * @package App\Models
 */
class LlxCategorie extends Model
{
	protected $table = 'llx_categorie';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'fk_parent' => 'int',
		'type' => 'int',
		'fk_soc' => 'int',
		'visible' => 'int',
		'date_creation' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int'
	];

	protected $fillable = [
		'entity',
		'fk_parent',
		'label',
		'ref_ext',
		'type',
		'description',
		'color',
		'fk_soc',
		'visible',
		'date_creation',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'import_key'
	];

	public function llx_categorie_accounts()
	{
		return $this->hasMany(LlxCategorieAccount::class, 'fk_categorie');
	}

	public function llx_categorie_actioncomms()
	{
		return $this->hasMany(LlxCategorieActioncomm::class, 'fk_categorie');
	}

	public function llx_categorie_contacts()
	{
		return $this->hasMany(LlxCategorieContact::class, 'fk_categorie');
	}

	public function llx_categorie_fournisseurs()
	{
		return $this->hasMany(LlxCategorieFournisseur::class, 'fk_categorie');
	}

	public function llx_categorie_knowledgemanagements()
	{
		return $this->hasMany(LlxCategorieKnowledgemanagement::class, 'fk_categorie');
	}

	public function llx_categorie_langs()
	{
		return $this->hasMany(LlxCategorieLang::class, 'fk_category');
	}

	public function llx_categorie_members()
	{
		return $this->hasMany(LlxCategorieMember::class, 'fk_categorie');
	}

	public function llx_categorie_products()
	{
		return $this->hasMany(LlxCategorieProduct::class, 'fk_categorie');
	}

	public function llx_categorie_projects()
	{
		return $this->hasMany(LlxCategorieProject::class, 'fk_categorie');
	}

	public function llx_categorie_societes()
	{
		return $this->hasMany(LlxCategorieSociete::class, 'fk_categorie');
	}

	public function llx_categorie_tickets()
	{
		return $this->hasMany(LlxCategorieTicket::class, 'fk_categorie');
	}

	public function llx_categorie_users()
	{
		return $this->hasMany(LlxCategorieUser::class, 'fk_categorie');
	}

	public function llx_categorie_warehouses()
	{
		return $this->hasMany(LlxCategorieWarehouse::class, 'fk_categorie');
	}

	public function llx_categorie_website_pages()
	{
		return $this->hasMany(LlxCategorieWebsitePage::class, 'fk_categorie');
	}

	public function llx_element_categories()
	{
		return $this->hasMany(LlxElementCategorie::class, 'fk_categorie');
	}
}
