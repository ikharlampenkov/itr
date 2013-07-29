<?php

class GuestBookController extends Zend_Controller_Action
{

    /**
     * @var SM_Menu_Item
     */
    protected $_link;

    /**
     * @var SM_Module_GuestBook|null
     */
    protected $_parent = null;


    public function init()
    {
        $this->_link = SM_Menu_Item::getInstanceByLink($this->getRequest()->getParam('link'));
        $this->view->assign('link', $this->_link->getLink());
        $this->view->assign('linkInfo', $this->_link);
        $this->view->assign('pathway', $this->_link->getPathWay());

        $parent = $this->getRequest()->getParam('parent', '');
        if (!empty($parent)) {
            $this->_parent = SM_Module_GuestBook::getInstanceById($parent);
        }
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->assign('questionList', SM_Module_GuestBook::getAllInstance($this->_link, $this->_parent));
        $this->view->assign('folder', $this->_parent);
    }

    public function viewQuestionAction()
    {
        $oQuestion = SM_Module_GuestBook::getInstanceById($this->getRequest()->getParam('id'));
        $this->view->assign('question', $oQuestion);
    }

    public function viewAction()
    {
        $mainSession = new Zend_Session_Namespace('guestBook');

        if (!isset($mainSession->isComplite)) {
            $mainSession->isComplite = false;
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');

            $oQuestion = new SM_Module_GuestBook();
            $oQuestion->setLink($this->_link);
            $oQuestion->setQuestion($data['question']);
            $oQuestion->setAnswer($data['answer']);
            $oQuestion->setSubject($data['subject']);
            $oQuestion->setName($data['name']);
            $oQuestion->setEmail($data['email']);
            $oQuestion->setModerate(false);

            try {
                $mainSession->isComplite = true;
                $this->_redirect('/' . $this->_link->getParent()->getLink() . '/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('isComplite', $mainSession->isComplite);

        if ($mainSession->isComplite == true) {
            $mainSession->isComplite = false;
        }

        $this->view->assign('questionList', SM_Module_GuestBook::getAllInstance($this->_link, SM_Module_GuestBook::IS_MODERATE));
    }

    public function addAction()
    {
        $oQuestion = new SM_Module_GuestBook();
        $oQuestion->setLink($this->_link);
        $oQuestion->setParent($this->_parent);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oQuestion->setQuestion($data['question']);
            $oQuestion->setAnswer($data['answer']);
            $oQuestion->setParent($data['parent']);
            $oQuestion->setSubject($data['subject']);
            $oQuestion->setName($data['name']);
            $oQuestion->setEmail($data['email']);
            $oQuestion->setModerate(true);
            $oQuestion->setIsFolder(false);

            try {
                $oQuestion->insertToDb();
                $this->_redirect('/guest-book/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('question', $oQuestion);
        $this->view->assign('folderList', SM_Module_GuestBook::getFolderList($this->_link, SM_Module_GuestBook::IS_ROOT));
    }

    public function editAction()
    {
        $oQuestion = SM_Module_GuestBook::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oQuestion->setQuestion($data['question']);
            $oQuestion->setAnswer($data['answer']);
            $oQuestion->setParent($data['parent']);
            $oQuestion->setSubject($data['subject']);
            $oQuestion->setName($data['name']);
            $oQuestion->setEmail($data['email']);
            $oQuestion->setModerate(true);
            $oQuestion->setIsFolder(false);

            try {
                $oQuestion->updateToDB();
                $this->_redirect('/guest-book/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('question', $oQuestion);
        $this->view->assign('folderList', SM_Module_GuestBook::getFolderList($this->_link, $this->_parent));
    }

    public function deleteAction()
    {
        $oQuestion = SM_Module_GuestBook::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oQuestion->deleteFromDB();
            $this->_redirect('/guest-book/index/link/' . $this->_link->getLink());
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }

    public function addFolderAction()
    {
        $oQuestion = new SM_Module_GuestBook();
        $oQuestion->setLink($this->_link);
        $oQuestion->setParent($this->_parent);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oQuestion->setQuestion($data['question']);
            $oQuestion->setAnswer('');
            $oQuestion->setParent($data['parent']);
            $oQuestion->setSubject('');
            $oQuestion->setName('');
            $oQuestion->setEmail('');
            $oQuestion->setModerate(true);
            $oQuestion->setIsFolder(true);

            try {
                $oQuestion->insertToDb();
                $this->_redirect('/guest-book/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('question', $oQuestion);
        $this->view->assign('folderList', SM_Module_GuestBook::getFolderList($this->_link, SM_Module_GuestBook::IS_ROOT));
    }

    public function editFolderAction()
    {
        $oQuestion = SM_Module_GuestBook::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oQuestion->setQuestion($data['question']);
            $oQuestion->setAnswer('');
            $oQuestion->setParent($data['parent']);
            $oQuestion->setSubject('');
            $oQuestion->setName('');
            $oQuestion->setEmail('');
            $oQuestion->setModerate(true);
            $oQuestion->setIsFolder(true);

            try {
                $oQuestion->updateToDB();
                $this->_redirect('/guest-book/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('question', $oQuestion);
        $this->view->assign('folderList', SM_Module_GuestBook::getFolderList($this->_link, $this->_parent));
    }

    public function deleteFolderAction()
    {
        $oQuestion = SM_Module_GuestBook::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oQuestion->deleteFromDB();
            $this->_redirect('/guest-book/index/link/' . $this->_link->getLink());
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }
}