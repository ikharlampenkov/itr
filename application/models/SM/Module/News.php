<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 27.05.12
 * Time: 14:27
 * To change this template use File | Settings | File Templates.
 */

/*
 * CREATE TABLE IF NOT EXISTS `news` (
   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `link_id` int(10) unsigned NOT NULL,
   `date_public` datetime NOT NULL,
   `title` varchar(255) NOT NULL,
   `file` varchar(255) DEFAULT NULL,
   `short_text` text,
   `full_text` text,
   `date_create` date NOT NULL,
   PRIMARY KEY (`id`),
   KEY `link_id` (`link_id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
 */

class SM_Module_News
{

    const TOP_NEWS_COUNT = 1;

    /**
     * @var int
     */
    protected $_id;

    /**
     * @var SM_Menu_Item
     */
    protected $_link;

    /**
     * @var string
     */
    protected $_title;

    /**
     * @var string
     */
    protected $_datePublic;

    /**
     * @var string
     */
    protected $_shortText = '';

    /**
     * @var string
     */
    protected $_fullText = '';

    /**
     * @var TM_FileManager_Image|null
     */
    protected $_file = null;

    /**
     * @var string
     */
    protected $_dateCreate;

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db = null;


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
     * @param \SM_Menu_Item $link
     */
    public function setLink($link)
    {
        $this->_link = $link;
    }

    /**
     * @return \SM_Menu_Item
     */
    public function getLink()
    {
        return $this->_link;
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
     * @param null|\TM_FileManager_File $file
     */
    protected function setFile($file)
    {
        if (is_null($this->_file)) {
            $this->_file = $file;
        } else {
            $this->_file->setName($file);
        }
    }

    /**
     * @return null|\TM_FileManager_File
     */
    public function getFile()
    {
        return $this->_file;
    }

    /**
     * @param string $fullText
     */
    public function setFullText($fullText)
    {
        $this->_fullText = $fullText;
    }

    /**
     * @return string
     */
    public function getFullText()
    {
        return stripslashes($this->_fullText);
    }

    /**
     * @param string $shortText
     */
    public function setShortText($shortText)
    {
        $this->_shortText = $shortText;
    }

    /**
     * @return string
     */
    public function getShortText()
    {
        return $this->_shortText;
    }

    /**
     * @param string $date_public
     */
    public function setDatePublic($date_public)
    {
        $this->_datePublic = date('Y-m-d', strtotime($date_public));
    }

    /**
     * @return string
     */
    public function getDatePublic()
    {
        return $this->_datePublic;
    }

    public function __get($name)
    {
        $method = "get{$name}";
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }

    protected function _prepareNull($value)
    {
        if (is_null($value) || empty($value)) {
            return null;
        } else {
            return $value->getId();
        }

    }

    public function  __construct()
    {
        $config = Zend_Registry::get('production');
        $this->_db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);

        $this->_dateCreate = date('Y-m-d');
        $this->_datePublic = date('Y-m-d');

        $this->_file = new TM_FileManager_Image($config->files->path);
    }

    public function insertToDB()
    {
        try {
            $sql = 'INSERT INTO news(link_id, title, date_public, date_create, short_text, full_text)
                                    VALUES(:link_id, :title, :date_public, :date_create, :short_text, :full_text)';
            $this->_db->query($sql, array('link_id' => $this->_link->getId(), 'title' => $this->_title, 'date_create' => $this->_dateCreate,
                'date_public' => $this->_datePublic, 'short_text' => $this->_shortText, 'full_text' => $this->_fullText));

            $this->_id = $this->_db->lastInsertId();

            $fileName = $this->_file->download('file');
            if ($fileName !== false) {
                $this->_file->createPreview(40, 40);
                $this->_db->query('UPDATE news SET file=:file WHERE id=:id', array('file' => $fileName, 'id' => $this->_id));
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    //link_id, title, date_public, date_create, short_text, full_text, file

    public function updateToDB()
    {
        try {
            $sql = 'UPDATE news
                       SET link_id=:link_id, title=:title, date_public=:date_public, date_create=:date_create,
                           short_text=:short_text, full_text=:full_text
                     WHERE id=:id';
            $this->_db->query($sql, array('link_id' => $this->_link->getId(), 'title' => $this->_title, 'date_create' => $this->_dateCreate,
                'date_public' => $this->_datePublic, 'short_text' => $this->_shortText, 'full_text' => $this->_fullText, 'id' => $this->_id));

            $fileName = $this->_file->download('file');
            if ($fileName !== false) {
                $this->_file->createPreview(40, 40);
                $this->_db->query('UPDATE news SET file=:file WHERE id=:id', array('file' => $fileName, 'id' => $this->_id));
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteFromDB()
    {
        try {
            $this->_file->delete();

            $sql = 'DELETE FROM news WHERE id=:id';
            $this->_db->query($sql, array('id' => $this->_id));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @static
     * @param $link
     * @return array|bool
     * @throws Exception
     */
    public static function getAllInstance($link)
    {
        try {
            $sql = 'SELECT * FROM news WHERE link_id=:link_id ORDER BY date_public DESC';
            $bind = array('link_id' => $link->getId());

            $config = Zend_Registry::get('production');
            $db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);

            $result = $db->query($sql, $bind)->fetchAll();

            if (isset($result[0])) {
                $retArray = array();
                foreach ($result as $res) {
                    $retArray[] = SM_Module_News::getInstanceByArray($res);
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
     * @param $link
     * @return array|bool
     * @throws Exception
     */
    public static function getTopNewsInstance($link)
    {
        try {
            $sql = 'SELECT * FROM news WHERE link_id=:link_id ORDER BY date_public DESC LIMIT ' . SM_Module_News::TOP_NEWS_COUNT;
            $bind = array('link_id' => $link->getId());

            $config = Zend_Registry::get('production');
            $db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);

            $result = $db->query($sql, $bind)->fetchAll();

            if (isset($result[0])) {
                $retArray = array();
                foreach ($result as $res) {
                    $retArray[] = SM_Module_News::getInstanceByArray($res);
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

    public static function getAllTopNewsInstance()
    {
        try {
            $sql = 'SELECT * FROM news ORDER BY date_public DESC LIMIT ' . SM_Module_News::TOP_NEWS_COUNT;
            $bind = array();

            $config = Zend_Registry::get('production');
            $db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);

            $result = $db->query($sql, $bind)->fetchAll();

            if (isset($result[0])) {
                $retArray = array();
                foreach ($result as $res) {
                    $retArray[] = SM_Module_News::getInstanceByArray($res);
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
     * @param $values
     * @return SM_Module_Document
     * @throws Exception
     */
    public static function getInstanceByArray($values)
    {
        try {
            $o = new SM_Module_News();
            $o->fillFromArray($values);
            return $o;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @static
     * @param $id
     * @return bool|SM_Module_Document
     * @throws Exception
     */
    public static function getInstanceById($id)
    {
        try {
            $sql = 'SELECT * FROM news WHERE id=:id';
            $config = Zend_Registry::get('production');

            $db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);
            $result = $db->query($sql, array('id' => $id))->fetchAll();

            if (isset($result[0])) {
                $o = new SM_Module_News();
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
        $this->setDateCreate($values['date_create']);
        $this->setDatePublic($values['date_public']);
        $this->setShortText($values['short_text']);
        $this->setFullText($values['full_text']);

        $this->setFile($values['file']);

        $oMenuItem = SM_Menu_Group::getInstanceById($values['link_id']);
        if ($oMenuItem === false) {
            $oMenuItem = SM_Menu_Item::getInstanceById($values['link_id']);
        }
        $this->setLink($oMenuItem);
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
