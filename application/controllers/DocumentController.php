<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 25.05.12
 * Time: 23:16
 * To change this template use File | Settings | File Templates.
 */
class DocumentController extends Zend_Controller_Action
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
        $parentId = $this->getRequest()->getParam('parent', 0);

        $this->view->assign('documentFolderList', SM_Module_DocumentFolder::getAllInstance($this->_link, $parentId));
        $this->view->assign('documentList', SM_Module_Document::getAllInstance($this->_link, $parentId));

        if ($parentId != 0) {
            $curFolder = SM_Module_DocumentFolder::getInstanceById($parentId);

            $this->view->assign('folder', $curFolder);
            $this->view->assign('breadcrumbs', $curFolder->getPathToDocument());
        }

        $this->view->assign('parentId', $parentId);
    }

    public function viewdocAction()
    {
        $parentId = $this->getRequest()->getParam('parent', 0);
        $oDocument = SM_Module_Document::getInstanceById($this->getRequest()->getParam('id'));

        $this->view->assign('document', $oDocument);
    }

    public function viewAction()
    {
        $parentId = $this->getRequest()->getParam('parent', 0);

        $this->view->assign('documentFolderList', SM_Module_DocumentFolder::getAllInstance($this->_link, $parentId));
        $this->view->assign('documentList', SM_Module_Document::getAllInstance($this->_link, $parentId));

        if ($parentId != 0) {
            $curFolder = SM_Module_DocumentFolder::getInstanceById($parentId);

            $this->view->assign('folder', $curFolder);
            $this->view->assign('breadcrumbs', $curFolder->getPathToDocument());
        }

        $this->view->assign('parentId', $parentId);
    }

    public function addAction()
    {
        $oDocument = new SM_Module_Document();

        if ($this->getRequest()->getParam('parent', 0) != 0) {
            $oDocument->setParent(SM_Module_DocumentFolder::getInstanceById($this->getRequest()->getParam('parent', 0)));
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oDocument->setLink($this->_link);
            $oDocument->setTitle($data['title']);
            $oDocument->setShortText($data['short_text']);
            $oDocument->setFullText($data['full_text']);

            if (!empty($data['parent'])) {
                $oDocument->setParent(SM_Module_DocumentFolder::getInstanceById($data['parent']));
            }

            try {
                $oDocument->insertToDb();
                $this->_redirect('/document/index/parent/' . $this->getRequest()->getParam('parent', 0) . '/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('document', $oDocument);
        $this->view->assign('documentFolderList', SM_Module_DocumentFolder::getAllInstance($this->_link, 0));
    }

    public function editAction()
    {
        $oDocument = SM_Module_Document::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->getParam('parent', 0) != 0) {
            $oDocument->setParent(SM_Module_DocumentFolder::getInstanceById($this->getRequest()->getParam('parent', 0)));
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oDocument->setTitle($data['title']);
            $oDocument->setShortText($data['short_text']);
            $oDocument->setFullText($data['full_text']);

            if (!empty($data['parent'])) {
                $oDocument->setParent(SM_Module_DocumentFolder::getInstanceById($data['parent']));
            }

            try {
                $oDocument->updateToDB();
                $this->_redirect('/document/index/parent/' . $this->getRequest()->getParam('parent', 0) . '/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('document', $oDocument);
        $this->view->assign('documentFolderList', SM_Module_DocumentFolder::getAllInstance($this->_link, 0));
    }

    public function deleteAction()
    {
        $oDocument = SM_Module_Document::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oDocument->deleteFromDB();
            $this->_redirect('/document/index/parent/' . $this->getRequest()->getParam('parent', 0) . '/link/' . $this->_link->getLink());
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }

    public function addfolderAction()
    {
        $oFolder = new SM_Module_DocumentFolder();

        if ($this->getRequest()->getParam('parent', 0) != 0) {
            $oFolder->setParent(SM_Module_DocumentFolder::getInstanceById($this->getRequest()->getParam('parent', 0)));
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oFolder->setLink($this->_link);
            $oFolder->setTitle($data['title']);

            if (!empty($data['parent'])) {
                $oFolder->setParent(SM_Module_DocumentFolder::getInstanceById($data['parent']));
            }

            try {
                $oFolder->insertToDb();
                $this->_redirect('/document/index/parent/' . $this->getRequest()->getParam('parent', 0) . '/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('document', $oFolder);
        $this->view->assign('documentFolderList', SM_Module_DocumentFolder::getAllInstance($this->_link, 0));
    }

    public function editfolderAction()
    {
        $oFolder = SM_Module_DocumentFolder::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->getParam('parent', 0) != 0) {
            $oFolder->setParent(SM_Module_DocumentFolder::getInstanceById($this->getRequest()->getParam('parent', 0)));
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oFolder->setTitle($data['title']);

            if (!empty($data['parent'])) {
                $oFolder->setParent(SM_Module_DocumentFolder::getInstanceById($data['parent']));
            }

            try {
                $oFolder->updateToDB();
                $this->_redirect('/document/index/parent/' . $this->getRequest()->getParam('parent', 0) . '/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('document', $oFolder);
        $this->view->assign('documentFolderList', SM_Module_DocumentFolder::getAllInstance($this->_link, 0));
    }

    public function deletefolderAction()
    {
        $oFolder = SM_Module_DocumentFolder::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oFolder->deleteFromDB();
            $this->_redirect('/document/index/parent/' . $this->getRequest()->getParam('parent', 0) . '/link/' . $this->_link->getLink());
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }

    }

}
