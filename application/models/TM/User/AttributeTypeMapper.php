<?php

/**
 * class TM_User_AttributeType
 *
 */
class TM_User_AttributeTypeMapper extends TM_Attribute_AttributeTypeMapper
{

    public function __construct()
    {
        parent::__construct();

    }

    /**
     *
     *
     * @return void
     */
    public function insertToDB($type)
    {
        try {
            $sql = 'INSERT INTO tm_user_attribute_type(title, `handler`, description) VALUES (:title, :handler, :description)';
            $this->_db->query($sql, array('title' => $type->title, 'handler' => $type->handler, 'description' => $type->description));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    /**
     *
     *
     * @return void
     * @access public
     */
    public function updateToDB($type)
    {
        try {
            $sql
                = 'UPDATE tm_user_attribute_type
                    SET title=:title, `handler`=:handler, description=:description
                    WHERE id=:id';
            $this->_db->query($sql, array('title' => $type->title, 'handler' => $type->handler, 'description' => $type->description, 'id' => $type->id));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *
     *
     * @return
     * @access public
     */
    public function deleteFromDB($type)
    {
        try {
            $sql = 'DELETE FROM tm_user_attribute_type WHERE id=:id';
            $this->_db->query($sql, array('id' => $type->id));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *
     *
     * @param int $id
     *
     * @throws Exception
     * @return TM_Attribute_AttributeType
     * @access public
     */
    public function getInstanceById($id)
    {
        try {
            $db = Zend_Registry::get('db');
            $sql = 'SELECT * FROM tm_user_attribute_type WHERE id=:id';
            $result = $db->query($sql, array('id' => $id))->fetchAll();

            if (isset($result[0])) {
                $class = $result[0]['handler'];
                $o = new $class($this);
                $o->fillFromArray($result[0]);
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
     * @return array
     * @access public
     */
    public function getAllInstance()
    {
        try {
            $db = Zend_Registry::get('db');
            $sql = 'SELECT * FROM tm_user_attribute_type';
            $result = $db->query($sql)->fetchAll();

            if (isset($result[0])) {
                $retArray = array();
                foreach ($result as $res) {
                    $retArray[] = TM_Attribute_AttributeTypeFactory::getAttributeTypeByArray($this, $res);
                }
                return $retArray;
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
     * @return TM_Attribute_AttributeType
     * @access public
     */
    public function getInstanceByArray($values)
    {
        try {
            $class = $values['handler'];
            $o = new $class($this);
            $o->fillFromArray($values);
            return $o;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return bool|array
     */
    public function selectFromDB($id)
    {
        try {
            $db = Zend_Registry::get('db');
            $sql = 'SELECT * FROM tm_user_attribute_type WHERE id=:id';
            $result = $db->query($sql, array('id' => $id))->fetchAll();

            if (isset($result[0])) {
                return $result[0];
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
} // end of TM_User_AttributeType
?>
