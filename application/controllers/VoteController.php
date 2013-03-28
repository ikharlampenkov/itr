<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 27.05.12
 * Time: 19:28
 * To change this template use File | Settings | File Templates.
 */

class VoteController extends Zend_Controller_Action
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
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');

            try {
                SM_Module_Vote::saveVoteEmail($this->_link, $data['email']);
                $this->_redirect('/vote/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('voteEmail', SM_Module_Vote::getVoteEmail($this->_link));
    }

    public function sendmsgAction()
    {
        $mainSession = new Zend_Session_Namespace('vote');

        if (!isset($mainSession->isComplite)) {
            $mainSession->isComplite = false;
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');

            try {
                SM_Module_Vote::sendVote($this->_link, $data);
                $mainSession->isComplite = true;
                $this->_redirect('/' . $this->_link->getGroup()->getLink() . '/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('isComplite', $mainSession->isComplite);

        if ($mainSession->isComplite == true) {
            $mainSession->isComplite = false;
        }
    }


}
