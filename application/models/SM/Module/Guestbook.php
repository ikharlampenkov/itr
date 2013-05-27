<?php
/*
CREATE TABLE `tblguestbook` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 50 ) NOT NULL DEFAULT ' ',
`email` VARCHAR( 50 ) NOT NULL DEFAULT ' ',
`subject` VARCHAR( 255 ) NOT NULL DEFAULT ' ',
`message` TEXT NOT NULL ,
`answer` TEXT NULL ,
`moderate` TINYINT( 1 ) NOT NULL DEFAULT '0'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

*/
class SM_Module_GuestBook
{

    /**
     * @var int
     */
    private $_id = 0;

    /**
     * @var SM_Menu_Item
     */
    private $_link = null;

    /**
     * @var string
     */
    private $_name = '';

    /**
     * @var string
     */
    private $_email = '';

    /**
     * @var string
     */
    private $_subject = '';

    /**
     * @var string
     */
    private $_question = '';

    /**
     * @var string
     */
    private $_answer = '';

    /**
     * @var bool
     */
    private $_moderate = false;

    /**
     * @var string
     */
    private $_dateCreate = '';

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    private $_db = null;

    /**
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->_answer = $answer;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->_answer;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
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
     * @param boolean $moderate
     */
    public function setModerate($moderate)
    {
        $this->_moderate = $moderate;
    }

    /**
     * @return boolean
     */
    public function getModerate()
    {
        return $this->_moderate;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->_question = $question;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->_question;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->_subject = $subject;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->_subject;
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

    public function __construct()
    {
        $config = Zend_Registry::get('production');
        $this->_db = Zend_Registry::get('db');

        $this->_dateCreate = date('Y-m-d');
    }

    public function insertToDB()
    {
        try {
            $sql
                = 'INSERT INTO news(link_id, title, date_public, date_create, short_text, full_text, category_id)
                             VALUES(:link_id, :title, :date_public, :date_create, :short_text, :full_text, :category_id)';
            $this->_db->query(
                $sql, array('link_id' => $this->_link->getId(), 'title' => $this->_title, 'date_create' => $this->_dateCreate,
                    'date_public' => $this->_datePublic, 'short_text' => $this->_shortText, 'full_text' => $this->_fullText,
                    'category_id' => $this->_prepareNullCategory($this->_category))
            );

            $this->_id = $this->_db->lastInsertId('news', 'id');

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
            $sql
                = 'UPDATE news
                      SET link_id=:link_id, title=:title, date_public=:date_public, date_create=:date_create,
                           short_text=:short_text, full_text=:full_text, category_id=:category_id
                    WHERE id=:id';
            $this->_db->query(
                $sql, array('link_id' => $this->_link->getId(), 'title' => $this->_title, 'date_create' => $this->_dateCreate,
                    'date_public' => $this->_datePublic, 'short_text' => $this->_shortText, 'full_text' => $this->_fullText,
                    'category_id' => $this->_prepareNullCategory($this->_category), 'id' => $this->_id)
            );

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
     *
     * @param                             $link
     * @param SM_Module_NewsCategory|null $category
     *
     * @throws Exception
     * @return array|bool
     */
    public static function getAllInstance($link, $category = null)
    {
        try {
            $db = Zend_Registry::get('db');

            if ($category != null) {
                $sql = 'SELECT * FROM news WHERE link_id=:link_id AND category_id=:category_id ORDER BY date_public DESC';
                $bind = array('link_id' => $link->getId(), 'category_id' => $category->getId());
            } else {
                $sql = 'SELECT * FROM news WHERE link_id=:link_id ORDER BY date_public DESC';
                $bind = array('link_id' => $link->getId());
            }

            $result = $db->query($sql, $bind)->fetchAll();

            if (isset($result[0])) {
                $retArray = array();
                foreach ($result as $res) {
                    $retArray[] = SM_Module_GuestBook::getInstanceByArray($res);
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
     * @return SM_Module_Document
     * @throws Exception
     */
    public static function getInstanceByArray($values)
    {
        try {
            $o = new SM_Module_GuestBook();
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
     * @return bool|SM_Module_News
     * @throws Exception
     */
    public static function getInstanceById($id)
    {
        try {
            $sql = 'SELECT * FROM news WHERE id=:id';

            $db = Zend_Registry::get('db');
            $result = $db->query($sql, array('id' => $id))->fetchAll();

            if (isset($result[0])) {
                $o = new SM_Module_GuestBook();
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
     *
     * @return void
     * @access public
     */
    public function fillFromArray($values)
    {
        $this->setId($values['id']);
        $this->setName($values['name']);
        $this->setDateCreate($values['date_create']);

        $this->setSubject($values['subject']);
        $this->setEmail($values['email']);
        $this->setQuestion($values['question']);
        $this->setAnswer($values['answer']);
        $this->setModerate($values['moderate']);

        $oMenuItem = SM_Menu_Item::getInstanceById($values['link_id']);
        $this->setLink($oMenuItem);
    }

    public function getAllMsg($idrubric)
    {
        try {
            $res = $this->_db->query('SELECT * FROM tblguestbook WHERE catalogid=' . $idrubric . ' ORDER BY moderate', 2);
            if (isset($res) && !empty($res)) {
                $o_catalog = new vlm_catalog();
                $o_doctor = new vlm_doctors();
                foreach ($res as &$resi) {
                    $rubric = $o_catalog->getRubric($resi['catalogid']);
                    $resi['rubric'] = $rubric['name'];
                    $doctor = $o_doctor->getDoctor($resi['doctorid']);
                    $resi['doctor'] = $doctor['fio'];
                    foreach ($resi as &$value) {
                        if (is_string($value)) $value = stripslashes($value);
                    }
                }
                return $res;
            } else return false;
        } catch (Exception $e) {
            echo '<!--' . $e->getMessage() . '-->';
            return false;
        }
    }

    public function getMsg($id)
    {
        try {
            $res = $this->_db->query('SELECT * FROM tblguestbook WHERE id=' . (int)$id, 2);
            if (isset($res[0]) && !empty($res[0])) {
                $o_catalog = new vlm_catalog();
                $o_doctor = new vlm_doctors();
                $rubric = $o_catalog->getRubric($res[0]['catalogid']);
                $res[0]['rubric'] = $rubric['name'];
                $doctor = $o_doctor->getDoctor($res[0]['doctorid']);
                $res[0]['doctor'] = $doctor['fio'];
                foreach ($res[0] as &$value) {
                    if (is_string($value)) $value = stripslashes($value);
                }
                return $res[0];
            } else return false;
        } catch (Exception $e) {
            echo '<!--' . $e->getMessage() . '-->';
            return false;
        }
    }

    public function getModerateMsg($idrubric)
    {
        try {
            $res = $this->_db->query('SELECT * FROM tblguestbook WHERE moderate=1 AND catalogid=' . $idrubric, 2);
            if (isset($res) && !empty($res)) {
                $o_catalog = new vlm_catalog();
                $o_doctor = new vlm_doctors();
                foreach ($res as &$resi) {
                    $rubric = $o_catalog->getRubric($resi['catalogid']);
                    $resi['rubric'] = $rubric['name'];
                    $doctor = $o_doctor->getDoctor($resi['doctorid']);
                    $resi['doctor'] = $doctor['fio'];
                    foreach ($resi as &$value) {
                        if (is_string($value)) $value = stripslashes($value);
                    }
                }
                return $res;
            } else return false;
        } catch (Exception $e) {
            echo '<!--' . $e->getMessage() . '-->';
            return false;
        }
    }

    public function getAnswerCount()
    {
        try {
            $result = $this->_db->query('SELECT COUNT(id) AS ans_count, catalogid FROM tblguestbook WHERE moderate=1 GROUP BY catalogid', 2);

            if (isset($result) && !empty($result)) {
                $ret_array = array();
                foreach ($result as $res) {
                    $ret_array[$res['catalogid']] = $res['ans_count'];
                }
                return $ret_array;
            } else return false;

        } catch (Exception $e) {
            echo '<!--' . $e->getMessage() . '-->';
        }
    }

    public function addMsg($data)
    {
        try {
            $data = $this->_db->prepareArray($data);
            $data['message'] = trim($data['message']);
            $this->_db->query('INSERT INTO tblguestbook(name, email, catalogid, doctorid, message) VALUES("' . $data['name'] . '", "' . $data['email'] . '",
                       ' . $data['catalogid'] . ', ' . $data['doctorid'] . ', "' . $data['message'] . '")');
            if ($data['doctorid'] != 0) {
                $this->_sendMail($data['doctorid'], $data['name'], $data['message']);
            }

            $this->_sendMail($data['doctorid'], $data['name'], $data['message'], true);

        } catch (Exception $e) {
            echo '<!--' . $e->getMessage() . '-->';
        }
    }

    public function addAnswer($id, $data)
    {
        try {
            $data = $this->_db->prepareArray($data);
            if (isset($data['moderate'])) {
                $data['moderate'] = 1;
            } else $data['moderate'] = 0;
            $data['answer'] = trim($data['answer']);

            $sql = 'UPDATE tblguestbook SET answer="' . $data['answer'] . '", moderate=' . $data['moderate'];
            if (isset($data['name']) && !empty($data['name'])) $sql .= ', name="' . $data['name'] . '"';
            if (isset($data['email']) && !empty($data['email'])) $sql .= ', email="' . $data['email'] . '"';
            if (isset($data['subject']) && !empty($data['subject'])) $sql .= ', subject="' . $data['subject'] . '"';
            if (isset($data['message']) && !empty($data['message'])) $sql .= ', message="' . $data['message'] . '"';
            if (isset($data['catalogid']) && !empty($data['catalogid'])) $sql .= ', catalogid="' . $data['catalogid'] . '"';
            if (isset($data['doctorid']) && !empty($data['doctorid'])) $sql .= ', doctorid="' . $data['doctorid'] . '"';
            $sql .= ' WHERE id=' . (int)$id;

            $this->_db->query($sql);
        } catch (Exception $e) {
            echo '<!--' . $e->getMessage() . '-->';
        }
    }

    public function delMsg($id)
    {
        try {
            $this->_db->query('DELETE FROM tblguestbook WHERE id=' . (int)$id);
        } catch (Exception $e) {
            echo '<!--' . $e->getMessage() . '-->';
        }
    }

    private function _sendMail($doctorid, $name, $umessage, $iscontrol = false)
    {
        try {
            if ($iscontrol) {
                $email = $this->_db->query('SELECT value AS email FROM tblconfig WHERE namevar="smail"', 2);
            } else {
                $email = $this->_db->query('SELECT email FROM tbldoctors WHERE id=' . (int)$doctorid, 2);
            }
            if (isset($email) && !empty($email)) {
                $message = 'Пожалуйста,  не отвечайте на это письмо.
                        Оно отослано Вам автоматической службой отправки писем.

                        Посетитель задал вопрос. Информация о посетителе: 
 
                        ФИО: ' . $name . '
                        Вопрос: ' . $umessage . '
 
                        С наилучшими пожеланиями,
                        Автоматический Диспетчер Запросов,
                        "ОВП",
                        http://ovp.tomck.net';
                $subject = iconv('UTF-8', 'WINDOWS-1251//IGNORE', 'ОВП. Автоматический Диспетчер Запросов');
                $message = iconv('UTF-8', 'KOI8-R//IGNORE', $message);

                if (isset($email['email'])) {
                    return mail($email['email'], $subject, $message, 'From: support@ovp.tomck.net');
                }
                return true;
            }
        } catch (Exception $e) {
            echo '<!--' . $e->getMessage() . '-->';
        }
    }

}

?>