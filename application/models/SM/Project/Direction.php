<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 22.04.13
 * Time: 23:43
 * To change this template use File | Settings | File Templates.
 */

class SM_Project_Direction
{
    /**
     * @var int
     */
    protected $_id;

    /**
     * @var string
     */
    protected $_title;

    /**
     * @var SM_Project_Branch|null
     */
    protected $_branch = null;

    /**
     * @var string
     */
    protected $_dateCreate = '';

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;

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
     * @param null|\SM_Project_Branch $branch
     */
    public function setBranch($branch)
    {
        $this->_branch = $branch;
    }

    /**
     * @return null|\SM_Project_Branch
     */
    public function getBranch()
    {
        return $this->_branch;
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
     * @param SM_Project_Branch|null $value
     *
     * @return null|int
     */
    protected function _prepareNullBranch($value)
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
            $sql = 'INSERT INTO project_direction(title, branch_id, date_create) VALUES(:title, :branch_id, :date_create)';
            $this->_db->query($sql, array('title' => $this->_title, 'branch_id' => $this->_prepareNullBranch($this->_branch), 'date_create' => $this->_dateCreate));

            $this->_id = $this->_db->lastInsertId('project_direction', 'id');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    //id, title, date_create

    public function updateToDB()
    {
        try {
            $sql
                    = 'UPDATE project_direction
                          SET title=:title, branch_id=:branch_id, date_create=:date_create
                        WHERE id=:id';
            $this->_db->query($sql, array('title' => $this->_title, 'branch_id' => $this->_prepareNullBranch($this->_branch), 'date_create' => $this->_dateCreate, 'id' => $this->_id));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteFromDB()
    {
        try {
            $sql = 'DELETE FROM project_direction WHERE id=:id';
            $this->_db->query($sql, array('id' => $this->_id));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @static
     * @param null $branch
     * @throws Exception
     * @return array|bool
     */
    public static function getAllInstance($branch = null)
    {
        try {
            $db = Zend_Registry::get('db');

            $sql = 'SELECT * FROM project_direction';
            $bind = array();

            if ($branch == null) {
                $sql .= ' WHERE branch_id IS NULL ';
            } elseif (!empty($branch)) {
                $sql .= ' WHERE branch_id=:branch_id ';
                $bind = array('branch_id' => $branch);
            }

            $result = $db->query($sql, $bind)->fetchAll();

            if (isset($result[0])) {
                $retArray = array();
                foreach ($result as $res) {
                    $retArray[] = SM_Project_Direction::getInstanceByArray($res);
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
     * @return SM_Project_Direction
     * @throws Exception
     */
    public static function getInstanceByArray($values)
    {
        try {
            $o = new SM_Project_Direction();
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
     * @return bool|SM_Project_Direction
     * @throws Exception
     */
    public static function getInstanceById($id)
    {
        try {
            $sql = 'SELECT * FROM project_direction WHERE id=:id';

            $db = Zend_Registry::get('db');
            $result = $db->query($sql, array('id' => $id))->fetch();

            if (!empty($result)) {
                $o = new SM_Project_Direction();
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
        $this->setDateCreate($values['date_create']);

        $oBranch = SM_Project_Branch::getInstanceById($values['branch_id']);
        if ($oBranch !== false) {
            $this->setBranch($oBranch);
        }
    }

}