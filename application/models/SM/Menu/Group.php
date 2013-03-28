<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 21.05.12
 * Time: 23:15
 * To change this template use File | Settings | File Templates.
 */

/*
 * CREATE TABLE IF NOT EXISTS `menu_group` (
   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `title` varchar(255) NOT NULL,
   `link` varchar(255) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
 */

class SM_Menu_Group
{
    /**
     * @var int
     */
    protected $_id;

    /**
     * @var string
     * @access protected
     */
    protected $_title;

    /**
     * @var string
     * @access protected
     */
    protected $_link = '';

    /**
     * @var SM_Menu_Handler
     */
    protected $_handler = null;

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;


    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->_link = mb_convert_case(StdLib_Functions::translitIt($link), MB_CASE_LOWER, 'UTF-8');
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->_link;
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
     * @param \SM_Menu_Handler $handler
     */
    public function setHandler($handler)
    {
        $this->_handler = $handler;
    }

    /**
     * @return \SM_Menu_Handler
     */
    public function getHandler()
    {
        return $this->_handler;
    }

    protected function _prepareNull($value)
    {
        if (is_null($value) || empty($value)) {
            return null;
        } else {
            return $value->getId();
        }

    }

    public function getUrl($mode)
    {
        $tempURL = '/';
        if ($mode == 'guest') {
            $tempURL .= $this->_link . '/';
        } elseif ($mode == 'admin') {
            if ($this->_handler !== null && $this->_handler->getController() == 'Contentpage') {
                $tempURL .= $this->_handler->getController() . '/edit/title/' . $this->_link . '/link/' . $this->_link . '/';
            } elseif ($this->_handler !== null && $this->_handler->getController() == 'Document') {
                $tempURL .= $this->_handler->getController() . '/index/link/' . $this->_link . '/';
            } elseif ($this->_handler !== null && $this->_handler->getController() == 'News') {
                $tempURL .= $this->_handler->getController() . '/index/link/' . $this->_link . '/';
            } elseif ($this->_handler !== null && $this->_handler->getController() == 'Vote') {
                $tempURL .= $this->_handler->getController() . '/index/link/' . $this->_link . '/';
            } else {
                $tempURL .= $this->_link . '/';
            }

        }
        return $tempURL;
    }


    public function getRoute(Zend_Controller_Router_Rewrite &$router)
    {
        $defaults = array();
        $reqs = array();

        if ($this->_handler !== null && $this->_handler->getController() == 'Contentpage') {
            $defaults['controller'] = $this->_handler->getController();
            $defaults['action'] = 'view';
            $defaults['title'] = $this->_link;
            $defaults['link'] = $this->_link;

            $route = new Zend_Controller_Router_Route(
                '/' . $this->_link . '/',
                $defaults, $reqs
            );
            $router->addRoute($this->_link, $route);
        } elseif ($this->_handler !== null && $this->_handler->getController() == 'Document') {
            $defaults['controller'] = $this->_handler->getController();
            $defaults['action'] = 'view';
            $defaults['parent'] = 0;
            $defaults['link'] = $this->_link;

            $route = new Zend_Controller_Router_Route(
                '/' . $this->_link . '/',
                $defaults, $reqs
            );
            $router->addRoute($this->_link, $route);

            $route = new Zend_Controller_Router_Route(
                '/' . $this->_link . '/parent/:parent/',
                array('controller' => $this->_handler->getController(), 'action' => 'view', 'link' => $this->_link), array('parent' => '[\w\-]+')
            );
            $router->addRoute($this->_link . '-parent', $route);


            $route = new Zend_Controller_Router_Route(
                '/' . $this->_link . '/viewdoc/:id/parent/:parent/',
                array('controller' => $this->_handler->getController(), 'action' => 'viewdoc', 'link' => $this->_link), array('id' => '[\w\-]+', 'parent' => '[\w\-]+')
            );
            $router->addRoute($this->_link . '-viewdoc', $route);
        } elseif ($this->_handler !== null && $this->_handler->getController() == 'News') {
            $defaults['controller'] = $this->_handler->getController();
            $defaults['action'] = 'view';
            $defaults['link'] = $this->_link;

            $route = new Zend_Controller_Router_Route(
                '/' . $this->_link . '/',
                $defaults, $reqs
            );
            $router->addRoute($this->_link, $route);

            $route = new Zend_Controller_Router_Route(
                '/' . $this->_link . '/viewnews/:id/',
                array('controller' => $this->_handler->getController(), 'action' => 'viewnews', 'link' => $this->_link), array('id' => '[\w\-]+')
            );
            $router->addRoute($this->_link . '-viewnews', $route);
        } elseif ($this->_handler !== null && $this->_handler->getController() == 'Vote') {
            $defaults['controller'] = $this->_handler->getController();
            $defaults['action'] = 'sendmsg';
            $defaults['link'] = $this->_link;

            $route = new Zend_Controller_Router_Route(
                '/' . $this->_link . '/',
                $defaults, $reqs
            );
            $router->addRoute($this->_link, $route);
        } else {

        }
    }

    public function getPathWay()
    {
        return array();
    }

    public function __get($name)
    {
        $method = "get{$name}";
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }

    public function __construct()
    {
        $config = Zend_Registry::get('production');
        $this->_db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);
    }

    public function insertToDb()
    {
        try {
            $sql = 'INSERT INTO menu_group(title, link, handler_id)
                         VALUES (:title, :link, :handler_id)';
            $this->_db->query($sql, array('title' => $this->_title, 'link' => $this->_link, 'handler_id' => $this->_prepareNull($this->_handler)));

            $this->_id = $this->getLastInsertId();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateToDb()
    {
        try {
            $sql = 'UPDATE menu_group
                       SET title=:title, link=:link, handler_id=:handler_id
                     WHERE id=:id';
            $this->_db->query($sql, array('id' => $this->_id, 'title' => $this->_title, 'link' => $this->_link, 'handler_id' => $this->_prepareNull($this->_handler)));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function deleteFromDb()
    {
        try {
            $sql = 'DELETE FROM menu_group WHERE id=:id';
            $this->_db->query($sql, array('id' => $this->_id));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    /**
     * @static
     * @param $values
     * @return SM_Menu_Handler
     * @throws Exception
     */
    public static function getInstanceByArray($values)
    {
        try {
            $o = new SM_Menu_Group();
            $o->fillFromArray($values);
            return $o;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *
     *
     * @throws Exception
     * @return array
     * @static
     * @access public
     */
    public static function getAllInstance()
    {
        try {
            $sql = 'SELECT * FROM menu_group';

            $config = Zend_Registry::get('production');

            $db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params); //$this->config->db->type


            $result = $db->query($sql)->fetchAll();

            if (isset($result[0])) {
                $retArray = array();
                foreach ($result as $res) {
                    $retArray[] = SM_Menu_Group::getInstanceByArray($res);
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
     * @static
     * @param $id
     * @return bool|SM_Menu_Group
     * @throws Exception
     */
    public static function getInstanceById($id)
    {
        try {
            $sql = 'SELECT * FROM menu_group WHERE id=' . (int)$id;
            $config = Zend_Registry::get('production');

            $db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);
            $result = $db->query($sql)->fetchAll();

            if (isset($result[0])) {
                $o = new SM_Menu_Group();
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
     * @static
     * @param $link
     * @return bool|SM_Menu_Group
     * @throws Exception
     */
    public static function getInstanceByLink($link)
    {
        try {
            $sql = 'SELECT * FROM menu_group WHERE link=:link';
            $config = Zend_Registry::get('production');

            $db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);
            $result = $db->query($sql, array('link' => $link))->fetchAll();

            if (isset($result[0])) {
                $o = new SM_Menu_Group();
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
     * @param array $values
     * @return void
     * @access public
     */
    public function fillFromArray($values)
    {
        $this->setId($values['id']);
        $this->setTitle($values['title']);
        $this->setLink($values['link']);

        $oHandler = SM_Menu_Handler::getInstanceById($values['handler_id']);
        if ($oHandler !== false) {
            $this->setHandler($oHandler);
        }
    }

    public function getItemList()
    {
        try {
            $result = SM_Menu_Item::getAllInstanceByGroup($this);
            return $result;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    protected function getLastInsertId()
    {
        try {
            $sql = 'SELECT LAST_INSERT_ID()';
            $id = $this->_db->query($sql)->fetchAll(Zend_Db::FETCH_NUM);
            if (isset($id[0][0])) {
                return $id[0][0];
            } else {
                return 0;
            }
        } catch (StdLib_Exception $s_e) {
            throw new StdLib_Exception('Can`t return last id');
        }
    }
}
