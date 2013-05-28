<?php

class GuestBookController extends Zend_Controller_Action
{

    /**
     * @var SM_Menu_Item
     */
    protected $_link;


    public function init()
    {
        $this->_link = SM_Menu_Item::getInstanceByLink($this->getRequest()->getParam('link'));
        $this->view->assign('link', $this->_link->getLink());
        $this->view->assign('linkInfo', $this->_link);
        $this->view->assign('pathway', $this->_link->getPathWay());
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->assign('questionList', SM_Module_GuestBook::getAllInstance($this->_link));
    }

    public function viewQuestionAction()
    {
        $oQuestion = SM_Module_GuestBook::getInstanceById($this->getRequest()->getParam('id'));
        $this->view->assign('question', $oQuestion);
    }

    public function viewAction()
    {
        $this->view->assign('questionList', SM_Module_GuestBook::getAllInstance($this->_link, 1));
    }

    public function addAction()
    {
        $oQuestion = new SM_Module_GuestBook();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oQuestion->setLink($this->_link);
            $oQuestion->setTitle($data['title']);
            $oQuestion->setDatePublic($data['date']);
            $oQuestion->setShortText($data['short_text']);
            $oQuestion->setFullText($data['full_text']);

            try {
                $oQuestion->insertToDb();
                $this->_redirect('/guest-book/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('question', $oQuestion);
    }

    public function editAction()
    {
        $oQuestion = SM_Module_GuestBook::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oQuestion->setTitle($data['title']);
            $oQuestion->setDatePublic($data['date']);
            $oQuestion->setShortText($data['short_text']);
            $oQuestion->setFullText($data['full_text']);

            try {
                $oQuestion->updateToDB();
                $this->_redirect('/guest-book/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('question', $oQuestion);
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
}