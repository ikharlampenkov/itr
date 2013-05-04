<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 28.04.13
 * Time: 22:53
 * To change this template use File | Settings | File Templates.
 */

/*
 * CREATE TABLE project
 (
   id bigserial NOT NULL,
   title character varying(50) NOT NULL, -- Название проекта
   is_company boolean NOT NULL DEFAULT false, -- Вы - компания?
   company_title character varying, -- Название комании
   company_contact_fio character varying, -- Ф.И.О. контактного лица
   company_contact_phone character varying, -- Контактный телефон
   company_contact_email character varying, -- E-mail	*
   description character varying, -- Описание проекта
   resulting_products character varying(220), -- Вид результирующей продукции (или технологии) проекта
   basic_function character varying(1024), -- Базовые функции (по возможности не более 5)
   additional_features character varying(520), -- Дополнительные функции
   potential_customers character varying(520), -- Потенциальные потребители
   analogs character varying(1024), -- Существующие аналоги
   branch_id bigint, -- Отрасль
   stage_id bigint, -- Стадия проекта
   requirements_id bigint, -- Надо для завершения
   requirements_text character varying(520), -- Надо для завершения текст
   date_create date NOT NULL, -- Дата создания
   CONSTRAINT project_pkey PRIMARY KEY (id),
   CONSTRAINT project_branch_id_fkey FOREIGN KEY (branch_id)
       REFERENCES project_branch (id) MATCH SIMPLE
       ON UPDATE CASCADE ON DELETE RESTRICT,
   CONSTRAINT project_requirements_id_fkey FOREIGN KEY (requirements_id)
       REFERENCES project_requirements (id) MATCH SIMPLE
       ON UPDATE CASCADE ON DELETE RESTRICT,
   CONSTRAINT project_stage_id_fkey FOREIGN KEY (stage_id)
       REFERENCES project_stage (id) MATCH SIMPLE
       ON UPDATE CASCADE ON DELETE RESTRICT
 )
 WITH (
   OIDS=FALSE
 );
 ALTER TABLE project
   OWNER TO garage;
 COMMENT ON TABLE project
   IS 'Таблица проектов';
 COMMENT ON COLUMN project.title IS 'Название проекта';
 COMMENT ON COLUMN project.is_company IS 'Вы - компания?';
 COMMENT ON COLUMN project.company_title IS 'Название комании';
 COMMENT ON COLUMN project.company_contact_fio IS 'Ф.И.О. контактного лица';
 COMMENT ON COLUMN project.company_contact_phone IS 'Контактный телефон';
 COMMENT ON COLUMN project.company_contact_email IS 'E-mail	*					';
 COMMENT ON COLUMN project.description IS 'Описание проекта';
 COMMENT ON COLUMN project.resulting_products IS 'Вид результирующей продукции (или технологии) проекта';
 COMMENT ON COLUMN project.basic_function IS 'Базовые функции (по возможности не более 5)';
 COMMENT ON COLUMN project.additional_features IS 'Дополнительные функции';
 COMMENT ON COLUMN project.potential_customers IS 'Потенциальные потребители	';
 COMMENT ON COLUMN project.analogs IS 'Существующие аналоги';
 COMMENT ON COLUMN project.branch_id IS 'Отрасль';
 COMMENT ON COLUMN project.stage_id IS 'Стадия проекта';
 COMMENT ON COLUMN project.requirements_id IS 'Надо для завершения';
 COMMENT ON COLUMN project.requirements_text IS 'Надо для завершения текст		';
 COMMENT ON COLUMN project.date_create IS 'Дата создания';
 */

/**
 * Class SM_Project_Project
 */
class SM_Project_Project
{

    /**
     * @var int
     */
    private $_id;

    /**
     * @var string
     */
    private $_title;

    /**
     * @var bool
     */
    private $_isCompany = false;

    /**
     * @var string
     */
    private $_companyTitle = '';

    private $_companyContactFio = '';

    private $_companyContactPhone = '';

    private $_companyContactEmail = '';

    private $_description = '';

    private $_resultingProducts = '';

    private $_basicFunction = '';

    private $_additionalFeatures = '';

    private $_potentialCustomers = '';

    private $_analogs = '';

    /**
     * @var SM_Project_Branch
     */
    private $_branch = null;

    /**
     * @var SM_Project_Direction
     */
    private $_direction = null;

    /**
     * @var SM_Project_Stage
     */
    private $_stage = null;

    /**
     * @var SM_Project_Requirement
     */
    private $_requirement = null;

    /**
     * @var string
     */
    private $_requirementsText = '';

    /**
     * @var string
     */
    protected $_dateCreate = '';

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    private $_db;

    public function setAdditionalFeatures($additional_features)
    {
        $this->_additionalFeatures = $additional_features;
    }

    public function getAdditionalFeatures()
    {
        return $this->_additionalFeatures;
    }

    public function setAnalogs($analogs)
    {
        $this->_analogs = $analogs;
    }

    public function getAnalogs()
    {
        return $this->_analogs;
    }

    public function setBasicFunction($basic_function)
    {
        $this->_basicFunction = $basic_function;
    }

    public function getBasicFunction()
    {
        return $this->_basicFunction;
    }

    /**
     * @param \SM_Project_Branch $branch
     */
    public function setBranch($branch)
    {
        $this->_branch = $branch;
    }

    /**
     * @return \SM_Project_Branch
     */
    public function getBranch()
    {
        return $this->_branch;
    }

    /**
     * @param string $companyTitle
     */
    public function setCompanyTitle($companyTitle)
    {
        $this->_companyTitle = $companyTitle;
    }

    /**
     * @return string
     */
    public function getCompanyTitle()
    {
        return $this->_companyTitle;
    }

    public function setCompanyContactEmail($company_contact_email)
    {
        $this->_companyContactEmail = $company_contact_email;
    }

    public function getCompanyContactEmail()
    {
        return $this->_companyContactEmail;
    }

    public function setCompanyContactFio($company_contact_fio)
    {
        $this->_companyContactFio = $company_contact_fio;
    }

    public function getCompanyContactFio()
    {
        return $this->_companyContactFio;
    }

    public function setCompanyContactPhone($company_contact_phone)
    {
        $this->_companyContactPhone = $company_contact_phone;
    }

    public function getCompanyContactPhone()
    {
        return $this->_companyContactPhone;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @param \SM_Project_Direction $direction
     */
    public function setDirection($direction)
    {
        $this->_direction = $direction;
    }

    /**
     * @return \SM_Project_Direction
     */
    public function getDirection()
    {
        return $this->_direction;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param boolean $isCompany
     */
    public function setIsCompany($isCompany)
    {
        $this->_isCompany = $isCompany;
    }

    /**
     * @return boolean
     */
    public function getIsCompany()
    {
        return $this->_isCompany;
    }

    public function setPotentialCustomers($potential_customers)
    {
        $this->_potentialCustomers = $potential_customers;
    }

    public function getPotentialCustomers()
    {
        return $this->_potentialCustomers;
    }

    /**
     * @param \SM_Project_Requirement $requirement
     */
    public function setRequirement($requirement)
    {
        $this->_requirement = $requirement;
    }

    /**
     * @return \SM_Project_Requirement
     */
    public function getRequirement()
    {
        return $this->_requirement;
    }

    /**
     * @param string $requirementsText
     */
    public function setRequirementsText($requirementsText)
    {
        $this->_requirementsText = $requirementsText;
    }

    /**
     * @return string
     */
    public function getRequirementsText()
    {
        return $this->_requirementsText;
    }

    public function setResultingProducts($resulting_products)
    {
        $this->_resultingProducts = $resulting_products;
    }

    public function getResultingProducts()
    {
        return $this->_resultingProducts;
    }

    /**
     * @param \SM_Project_Stage $stage
     */
    public function setStage($stage)
    {
        $this->_stage = $stage;
    }

    /**
     * @return \SM_Project_Stage
     */
    public function getStage()
    {
        return $this->_stage;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }


    /**
     * @param string $dateCreate
     */
    public function setDateCreate($dateCreate)
    {
        $this->_dateCreate = date('Y-m-d', strtotime($dateCreate));
    }

    /**
     * @return string
     */
    public function getDateCreate()
    {
        return $this->_dateCreate;
    }

    public function __get($name)
    {
        $method = "get{$name}";
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            throw new Exception('Can not find method ' . $method . ' in class ' . __CLASS__);
        }
    }

    /**
     * @param SM_Project_Branch $value
     *
     * @return null|int
     */
    protected function _prepareNull($value)
    {
        if (is_null($value) || empty($value)) {
            return null;
        } else {
            return $value->getId();
        }
    }

    public function __construct()
    {
        $this->_db = Zend_Registry::get('db');

        $this->_dateCreate = date('Y-m-d');
    }

    public function insertToDB()
    {
        try {
            $sql
                = 'INSERT INTO project(title, is_company, company_title, company_contact_fio, company_contact_phone, company_contact_email, description,
                                        resulting_products, basic_function, additional_features, potential_customers, analogs, branch_id, direction_id, stage_id,
                                        requirements_id, requirements_text, date_create)
                         VALUES(:title, :is_company, :company_title, :company_contact_fio, :company_contact_phone, :company_contact_email, :description,
                                :resulting_products, :basic_function, :additional_features, :potential_customers, :analogs, :branch_id, :direction_id, :stage_id,
                                :requirements_id, :requirements_text, :date_create)';
            $this->_db->query(
                $sql, array('title'                 => $this->_title, 'is_company' => $this->_isCompany, 'company_title' => $this->_companyTitle, 'company_contact_fio' => $this->_companyContactFio,
                            'company_contact_phone' => $this->_companyContactPhone, 'company_contact_email' => $this->_companyContactEmail, 'description' => $this->_description,
                            'resulting_products'    => $this->_resultingProducts, 'basic_function' => $this->_basicFunction, 'additional_features' => $this->_additionalFeatures,
                            'potential_customers'   => $this->_potentialCustomers, 'analogs' => $this->_analogs, 'branch_id' => $this->_prepareNull($this->_branch),
                            'direction_id'          => $this->_prepareNull($this->_direction), 'stage_id' => $this->_prepareNull($this->_stage),
                            'requirements_id'       => $this->_prepareNull($this->_requirement), 'requirements_text' => $this->_requirementsText, 'date_create' => $this->_dateCreate)
            );

            $this->_id = $this->_db->lastInsertId('project', 'id');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    //title, is_company, company_title, company_contact_fio, company_contact_phone, company_contact_email, description character, resulting_products, basic_function, additional_features, potential_customers, analogs character, branch_id, stage_id, requirements_id, requirements_text, date_create

    public function updateToDB()
    {
        try {
            $sql
                = 'UPDATE project
                      SET title=:title, is_company=:is_company, company_title=:company_title, company_contact_fio=:company_contact_fio, company_contact_phone=:company_contact_phone,
                      company_contact_email=:company_contact_email, description=:description, resulting_products=:resulting_products, basic_function=:basic_function,
                      additional_features=:additional_features, potential_customers=:potential_customers, analogs=:analogs, branch_id=:branch_id, direction_id=:direction_id,
                      stage_id=:stage_id, requirements_id=:requirements_id, requirements_text=:requirements_text, date_create=:date_create
                    WHERE id=:id';
            $this->_db->query(
                $sql, array('title'                 => $this->_title, 'is_company' => $this->_isCompany, 'company_title' => $this->_companyTitle, 'company_contact_fio' => $this->_companyContactFio,
                            'company_contact_phone' => $this->_companyContactPhone, 'company_contact_email' => $this->_companyContactEmail, 'description' => $this->_description,
                            'resulting_products'    => $this->_resultingProducts, 'basic_function' => $this->_basicFunction, 'additional_features' => $this->_additionalFeatures,
                            'potential_customers'   => $this->_potentialCustomers, 'analogs' => $this->_analogs, 'branch_id' => $this->_prepareNull($this->_branch),
                            'direction_id'          => $this->_prepareNull($this->_direction), 'stage_id' => $this->_prepareNull($this->_stage),
                            'requirements_id'       => $this->_prepareNull($this->_requirement), 'requirements_text' => $this->_requirementsText, 'date_create' => $this->_dateCreate, 'id' => $this->_id)
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteFromDB()
    {
        try {
            $sql = 'DELETE FROM project WHERE id=:id';
            $this->_db->query($sql, array('id' => $this->_id));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @static
     * @return array|bool
     * @throws Exception
     */
    public static function getAllInstance()
    {
        try {
            $sql = 'SELECT * FROM project';

            $db = Zend_Registry::get('db');
            $result = $db->query($sql)->fetchAll();

            if (isset($result[0])) {
                $retArray = array();
                foreach ($result as $res) {
                    $retArray[] = SM_Project_Project::getInstanceByArray($res);
                }
                return $retArray;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @static
     *
     * @param $values
     *
     * @return SM_Project_Project
     * @throws Exception
     */
    public static function getInstanceByArray($values)
    {
        try {
            $o = new SM_Project_Project();
            $o->fillFromArray($values);
            return $o;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @static
     *
     * @param $id
     *
     * @return bool|SM_Project_Project
     * @throws Exception
     */
    public static function getInstanceById($id)
    {
        try {
            $sql = 'SELECT * FROM project WHERE id=:id';

            $db = Zend_Registry::get('db');
            $result = $db->query($sql, array('id' => $id))->fetch();

            if (!empty($result)) {
                $o = new SM_Project_Project();
                $o->fillFromArray($result);
                return $o;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *
     *
     * @param array $values
     *
     * @return void
     * @access public
     */
    public function fillFromArray($values)
    {
        $this->setId($values['id']);
        $this->setTitle($values['title']);

        $this->setIsCompany($values['is_company']);
        $this->setCompanyTitle($values['company_title']);
        $this->setCompanyContactFio($values['company_contact_fio']);
        $this->setCompanyContactPhone($values['company_contact_phone']);
        $this->setCompanyContactEmail($values['company_contact_email']);

        $this->setDescription($values['description']);
        $this->setResultingProducts($values['resulting_products']);
        $this->setBasicFunction($values['basic_function']);
        $this->setAdditionalFeatures($values['additional_features']);
        $this->setPotentialCustomers($values['potential_customers']);
        $this->setAnalogs($values['analogs']);

        $oBranch = SM_Project_Branch::getInstanceById($values['branch_id']);
        if ($oBranch !== false) {
            $this->setBranch($oBranch);
        }
        $oDirection = SM_Project_Direction::getInstanceById($values['direction_id']);
        if ($oDirection !== false) {
            $this->setDirection($oDirection);
        }
        $oStage = SM_Project_Stage::getInstanceById($values['stage_id']);
        if ($oStage !== false) {
            $this->setStage($oStage);
        }
        $oRequirements = SM_Project_Requirement::getInstanceById($values['requirements_id']);
        if ($oRequirements !== false) {
            $this->setRequirement($oRequirements);
        }

        $this->setRequirementsText($values['requirements_text']);
        $this->setDateCreate($values['date_create']);
    }


}