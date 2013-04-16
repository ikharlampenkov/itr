<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 16.04.13
 * Time: 22:35
 * To change this template use File | Settings | File Templates.
 */


class PartnersController extends Zend_Controller_Action
{
    /**
     * @var SM_Menu_Item
     */
    protected $_link = null;

    public function init()
    {
        $oItem = SM_Menu_Item::getInstanceByLink($this->getRequest()->getParam('link', ''));
        if ($oItem != false) {
            $this->_link = $oItem;
            $this->view->assign('link', $this->_link->getLink());
            $this->view->assign('pathway', $this->_link->getPathWay());
        }

        $this->view->assign('link', $this->_link);
        $this->view->assign('linkInfo', $this->_link);
        $this->view->assign('pathway', $this->_link);

        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->assign('partnersList', SM_Module_Partners::getAllInstance($this->_link));
    }

    public function viewAction()
    {
        $this->view->assign('partnersList', SM_Module_Partners::getAllInstance($this->_link));
    }

    public function addAction()
    {
        $oPartners = new SM_Module_Partners();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oPartners->setLink($this->_link);
            $oPartners->setTitle($data['title']);
            $oPartners->setUrl($data['url']);

            try {
                $oPartners->insertToDb();
                if ($this->_link != null) {
                    $this->_redirect('/partners/index/link/' . $this->_link->getLink());
                } else {
                    $this->_redirect('/partners/index/link/');
                }
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('partners', $oPartners);
    }

    public function editAction()
    {
        $oPartners = SM_Module_Partners::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oPartners->setTitle($data['title']);
            $oPartners->setUrl($data['url']);

            try {
                $oPartners->updateToDB();
                if ($this->_link != null) {
                    $this->_redirect('/partners/index/link/' . $this->_link->getLink());
                } else {
                    $this->_redirect('/partners/index/link/');
                }
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('partners', $oPartners);
    }

    public function deleteAction()
    {
        $oPartners = SM_Module_Partners::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oPartners->deleteFromDB();
            if ($this->_link != null) {
                $this->_redirect('/partners/index/link/' . $this->_link->getLink());
            } else {
                $this->_redirect('/partners/index/link/');
            }
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }
}