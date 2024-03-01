<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\dolibarr_19;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LlxUser
 *
 * @property int $rowid
 * @property int $entity
 * @property string|null $ref_employee
 * @property string|null $ref_ext
 * @property int|null $admin
 * @property int|null $employee
 * @property int|null $fk_establishment
 * @property Carbon|null $datec
 * @property Carbon|null $tms
 * @property int|null $fk_user_creat
 * @property int|null $fk_user_modif
 * @property string $login
 * @property string|null $pass_encoding
 * @property string|null $pass
 * @property string|null $pass_crypted
 * @property string|null $pass_temp
 * @property string|null $api_key
 * @property string|null $gender
 * @property string|null $civility
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $address
 * @property string|null $zip
 * @property string|null $town
 * @property int|null $fk_state
 * @property int|null $fk_country
 * @property Carbon|null $birth
 * @property string|null $birth_place
 * @property string|null $job
 * @property string|null $office_phone
 * @property string|null $office_fax
 * @property string|null $user_mobile
 * @property string|null $personal_mobile
 * @property string|null $email
 * @property string|null $personal_email
 * @property string|null $email_oauth2
 * @property string|null $signature
 * @property string|null $socialnetworks
 * @property int|null $fk_soc
 * @property int|null $fk_socpeople
 * @property int|null $fk_member
 * @property int|null $fk_user
 * @property int|null $fk_user_expense_validator
 * @property int|null $fk_user_holiday_validator
 * @property string|null $idpers1
 * @property string|null $idpers2
 * @property string|null $idpers3
 * @property string|null $note_public
 * @property string|null $note_private
 * @property string|null $model_pdf
 * @property string|null $last_main_doc
 * @property Carbon|null $datelastlogin
 * @property Carbon|null $datepreviouslogin
 * @property Carbon|null $datelastpassvalidation
 * @property Carbon|null $datestartvalidity
 * @property Carbon|null $dateendvalidity
 * @property Carbon|null $flagdelsessionsbefore
 * @property string|null $iplastlogin
 * @property string|null $ippreviouslogin
 * @property int|null $egroupware_id
 * @property string|null $ldap_sid
 * @property string|null $openid
 * @property int|null $statut
 * @property string|null $photo
 * @property string|null $lang
 * @property string|null $color
 * @property string|null $barcode
 * @property int|null $fk_barcode_type
 * @property string|null $accountancy_code
 * @property int|null $nb_holiday
 * @property float|null $thm
 * @property float|null $tjm
 * @property float|null $salary
 * @property float|null $salaryextra
 * @property Carbon|null $dateemployment
 * @property Carbon|null $dateemploymentend
 * @property float|null $weeklyhours
 * @property string|null $import_key
 * @property int|null $default_range
 * @property int|null $default_c_exp_tax_cat
 * @property string|null $national_registration_number
 * @property int|null $fk_warehouse
 *
 * @property Collection|LlxBomBom[] $llx_bom_boms
 * @property Collection|LlxCategorieUser[] $llx_categorie_users
 * @property Collection|LlxCommande[] $llx_commandes
 * @property Collection|LlxContrat[] $llx_contrats
 * @property Collection|LlxDelivery[] $llx_deliveries
 * @property Collection|LlxEcmDirectory[] $llx_ecm_directories
 * @property Collection|LlxExpedition[] $llx_expeditions
 * @property Collection|LlxFacture[] $llx_factures
 * @property Collection|LlxFactureFourn[] $llx_facture_fourns
 * @property Collection|LlxFactureFournRec[] $llx_facture_fourn_recs
 * @property Collection|LlxFactureRec[] $llx_facture_recs
 * @property Collection|LlxFichinterRec[] $llx_fichinter_recs
 * @property Collection|LlxHrmEvaluation[] $llx_hrm_evaluations
 * @property Collection|LlxHrmEvaluationdet[] $llx_hrm_evaluationdets
 * @property Collection|LlxHrmSkill[] $llx_hrm_skills
 * @property Collection|LlxHrmSkilldet[] $llx_hrm_skilldets
 * @property Collection|LlxHrmSkillrank[] $llx_hrm_skillranks
 * @property Collection|LlxKnowledgemanagementKnowledgerecord[] $llx_knowledgemanagement_knowledgerecords
 * @property Collection|LlxMrpMo[] $llx_mrp_mos
 * @property Collection|LlxPaymentSalary[] $llx_payment_salaries
 * @property Collection|LlxProductCustomerPrice[] $llx_product_customer_prices
 * @property Collection|LlxProductFournisseurPrice[] $llx_product_fournisseur_prices
 * @property Collection|LlxProjetTask[] $llx_projet_tasks
 * @property Collection|LlxPropal[] $llx_propals
 * @property Collection|LlxReception[] $llx_receptions
 * @property Collection|LlxRecruitmentRecruitmentcandidature[] $llx_recruitment_recruitmentcandidatures
 * @property Collection|LlxRecruitmentRecruitmentjobposition[] $llx_recruitment_recruitmentjobpositions
 * @property Collection|LlxSocieteRemiseExcept[] $llx_societe_remise_excepts
 * @property Collection|LlxSocperson[] $llx_socpeople
 * @property Collection|LlxStocktransferStocktransfer[] $llx_stocktransfer_stocktransfers
 * @property Collection|LlxUserEmployment[] $llx_user_employments
 * @property Collection|LlxUserRight[] $llx_user_rights
 * @property Collection|LlxUsergroupUser[] $llx_usergroup_users
 * @property Collection|LlxWebhookTarget[] $llx_webhook_targets
 * @property Collection|LlxWorkstationWorkstation[] $llx_workstation_workstations
 *
 * @package App\Models
 */
class LlxUser extends Model
{
	protected $table = 'llx_user';
	protected $primaryKey = 'rowid';
	public $timestamps = false;

	protected $casts = [
		'entity' => 'int',
		'admin' => 'int',
		'employee' => 'int',
		'fk_establishment' => 'int',
		'datec' => 'datetime',
		'tms' => 'datetime',
		'fk_user_creat' => 'int',
		'fk_user_modif' => 'int',
		'fk_state' => 'int',
		'fk_country' => 'int',
		'birth' => 'datetime',
		'fk_soc' => 'int',
		'fk_socpeople' => 'int',
		'fk_member' => 'int',
		'fk_user' => 'int',
		'fk_user_expense_validator' => 'int',
		'fk_user_holiday_validator' => 'int',
		'datelastlogin' => 'datetime',
		'datepreviouslogin' => 'datetime',
		'datelastpassvalidation' => 'datetime',
		'datestartvalidity' => 'datetime',
		'dateendvalidity' => 'datetime',
		'flagdelsessionsbefore' => 'datetime',
		'egroupware_id' => 'int',
		'statut' => 'int',
		'fk_barcode_type' => 'int',
		'nb_holiday' => 'int',
		'thm' => 'float',
		'tjm' => 'float',
		'salary' => 'float',
		'salaryextra' => 'float',
		'dateemployment' => 'datetime',
		'dateemploymentend' => 'datetime',
		'weeklyhours' => 'float',
		'default_range' => 'int',
		'default_c_exp_tax_cat' => 'int',
		'fk_warehouse' => 'int'
	];

	protected $fillable = [
		'entity',
		'ref_employee',
		'ref_ext',
		'admin',
		'employee',
		'fk_establishment',
		'datec',
		'tms',
		'fk_user_creat',
		'fk_user_modif',
		'login',
		'pass_encoding',
		'pass',
		'pass_crypted',
		'pass_temp',
		'api_key',
		'gender',
		'civility',
		'lastname',
		'firstname',
		'address',
		'zip',
		'town',
		'fk_state',
		'fk_country',
		'birth',
		'birth_place',
		'job',
		'office_phone',
		'office_fax',
		'user_mobile',
		'personal_mobile',
		'email',
		'personal_email',
		'email_oauth2',
		'signature',
		'socialnetworks',
		'fk_soc',
		'fk_socpeople',
		'fk_member',
		'fk_user',
		'fk_user_expense_validator',
		'fk_user_holiday_validator',
		'idpers1',
		'idpers2',
		'idpers3',
		'note_public',
		'note_private',
		'model_pdf',
		'last_main_doc',
		'datelastlogin',
		'datepreviouslogin',
		'datelastpassvalidation',
		'datestartvalidity',
		'dateendvalidity',
		'flagdelsessionsbefore',
		'iplastlogin',
		'ippreviouslogin',
		'egroupware_id',
		'ldap_sid',
		'openid',
		'statut',
		'photo',
		'lang',
		'color',
		'barcode',
		'fk_barcode_type',
		'accountancy_code',
		'nb_holiday',
		'thm',
		'tjm',
		'salary',
		'salaryextra',
		'dateemployment',
		'dateemploymentend',
		'weeklyhours',
		'import_key',
		'default_range',
		'default_c_exp_tax_cat',
		'national_registration_number',
		'fk_warehouse'
	];

	public function llx_bom_boms()
	{
		return $this->hasMany(LlxBomBom::class, 'fk_user_creat');
	}

	public function llx_categorie_users()
	{
		return $this->hasMany(LlxCategorieUser::class, 'fk_user');
	}

	public function llx_commandes()
	{
		return $this->hasMany(LlxCommande::class, 'fk_user_valid');
	}

	public function llx_contrats()
	{
		return $this->hasMany(LlxContrat::class, 'fk_user_author');
	}

	public function llx_deliveries()
	{
		return $this->hasMany(LlxDelivery::class, 'fk_user_valid');
	}

	public function llx_ecm_directories()
	{
		return $this->hasMany(LlxEcmDirectory::class, 'fk_user_m');
	}

	public function llx_expeditions()
	{
		return $this->hasMany(LlxExpedition::class, 'fk_user_valid');
	}

	public function llx_factures()
	{
		return $this->hasMany(LlxFacture::class, 'fk_user_valid');
	}

	public function llx_facture_fourns()
	{
		return $this->hasMany(LlxFactureFourn::class, 'fk_user_valid');
	}

	public function llx_facture_fourn_recs()
	{
		return $this->hasMany(LlxFactureFournRec::class, 'fk_user_author');
	}

	public function llx_facture_recs()
	{
		return $this->hasMany(LlxFactureRec::class, 'fk_user_author');
	}

	public function llx_fichinter_recs()
	{
		return $this->hasMany(LlxFichinterRec::class, 'fk_user_author');
	}

	public function llx_hrm_evaluations()
	{
		return $this->hasMany(LlxHrmEvaluation::class, 'fk_user_creat');
	}

	public function llx_hrm_evaluationdets()
	{
		return $this->hasMany(LlxHrmEvaluationdet::class, 'fk_user_creat');
	}

	public function llx_hrm_skills()
	{
		return $this->hasMany(LlxHrmSkill::class, 'fk_user_creat');
	}

	public function llx_hrm_skilldets()
	{
		return $this->hasMany(LlxHrmSkilldet::class, 'fk_user_creat');
	}

	public function llx_hrm_skillranks()
	{
		return $this->hasMany(LlxHrmSkillrank::class, 'fk_user_creat');
	}

	public function llx_knowledgemanagement_knowledgerecords()
	{
		return $this->hasMany(LlxKnowledgemanagementKnowledgerecord::class, 'fk_user_creat');
	}

	public function llx_mrp_mos()
	{
		return $this->hasMany(LlxMrpMo::class, 'fk_user_creat');
	}

	public function llx_payment_salaries()
	{
		return $this->hasMany(LlxPaymentSalary::class, 'fk_user');
	}

	public function llx_product_customer_prices()
	{
		return $this->hasMany(LlxProductCustomerPrice::class, 'fk_user');
	}

	public function llx_product_fournisseur_prices()
	{
		return $this->hasMany(LlxProductFournisseurPrice::class, 'fk_user');
	}

	public function llx_projet_tasks()
	{
		return $this->hasMany(LlxProjetTask::class, 'fk_user_valid');
	}

	public function llx_propals()
	{
		return $this->hasMany(LlxPropal::class, 'fk_user_valid');
	}

	public function llx_receptions()
	{
		return $this->hasMany(LlxReception::class, 'fk_user_valid');
	}

	public function llx_recruitment_recruitmentcandidatures()
	{
		return $this->hasMany(LlxRecruitmentRecruitmentcandidature::class, 'fk_user_creat');
	}

	public function llx_recruitment_recruitmentjobpositions()
	{
		return $this->hasMany(LlxRecruitmentRecruitmentjobposition::class, 'fk_user_supervisor');
	}

	public function llx_societe_remise_excepts()
	{
		return $this->hasMany(LlxSocieteRemiseExcept::class, 'fk_user');
	}

	public function llx_socpeople()
	{
		return $this->hasMany(LlxSocperson::class, 'fk_user_creat');
	}

	public function llx_stocktransfer_stocktransfers()
	{
		return $this->hasMany(LlxStocktransferStocktransfer::class, 'fk_user_creat');
	}

	public function llx_user_employments()
	{
		return $this->hasMany(LlxUserEmployment::class, 'fk_user');
	}

	public function llx_user_rights()
	{
		return $this->hasMany(LlxUserRight::class, 'fk_user');
	}

	public function llx_usergroup_users()
	{
		return $this->hasMany(LlxUsergroupUser::class, 'fk_user');
	}

	public function llx_webhook_targets()
	{
		return $this->hasMany(LlxWebhookTarget::class, 'fk_user_creat');
	}

	public function llx_workstation_workstations()
	{
		return $this->hasMany(LlxWorkstationWorkstation::class, 'fk_user_creat');
	}
}
