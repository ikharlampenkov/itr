<?php

class ContentpageController extends Zend_Controller_Action
{

    /**
     * @var SM_Menu_Item
     */
    protected $_link;

    public function init()
    {
        $this->_link = SM_Menu_Item::getInstanceByLink($this->getRequest()->getParam('link'));
        if ($this->_link == false) {
            $this->_link = SM_Menu_Group::getInstanceByLink($this->getRequest()->getParam('link'));
        }
        $this->view->assign('link', $this->_link->getLink());

        $this->view->assign('linkInfo', $this->_link);
        $this->view->assign('pathway', $this->_link->getPathWay());
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->assign('contentPageList', EK_Share_ContentPage::getAllInstance());
    }

    public function viewAction()
    {
        $oContentPage = SM_Module_ContentPage::getInstanceByTitle($this->getRequest()->getParam('title'));
        $this->view->assign('contentPage', $oContentPage);
    }

    public function addAction()
    {

        include_once Zend_Registry::get('production')->editor->path . 'ckeditor/ckeditor.php';
        include_once Zend_Registry::get('production')->editor->path . 'ckfinder/ckfinder.php';

        $CKEditor = new CKEditor();
        $CKEditor->basePath = '/ckeditor/';
        $CKEditor->returnOutput = true;

        $ckFinder = new CKFinder();
        $ckFinder->BasePath = '/ckfinder/';
        $ckFinder->SetupCKEditorObject($CKEditor);


        $oContentPage = new SM_Module_ContentPage();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oContentPage->setPageTitle($data['page_title']);
            $oContentPage->setTitle($data['title']);
            $oContentPage->setContent($data['content']);

            try {
                $oContentPage->insertToDb();
                $this->_redirect('/contentPage/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('ckeditor', $CKEditor->editor('data[content]', $oContentPage->getContent()));
        $this->view->assign('contentPage', $oContentPage);
    }

    public function editAction()
    {
        include_once Zend_Registry::get('production')->editor->path . 'ckeditor/ckeditor.php';
        include_once Zend_Registry::get('production')->editor->path . 'ckfinder/ckfinder.php';

        $CKEditor = new CKEditor();
        $CKEditor->basePath = '/ckeditor/';
        $CKEditor->returnOutput = true;

        $ckFinder = new CKFinder();
        $ckFinder->BasePath = '/ckfinder/';
        $ckFinder->SetupCKEditorObject($CKEditor);


        $oContentPage = SM_Module_ContentPage::getInstanceByTitle($this->getRequest()->getParam('title'));



        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oContentPage->setContent($data['content']);

            try {
                $oContentPage->updateToDb();
                $this->_redirect('/contentpage/edit/title/' . $this->getRequest()->getParam('title') . '/link/' . $this->getRequest()->getParam('link'));
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('ckeditor', $CKEditor->editor('data[content]', $oContentPage->getContent()));
        $this->view->assign('contentPage', $oContentPage);
    }

    public function deleteAction()
    {
        $oContentPage = SM_Module_ContentPage::getInstanceByTitle($this->getRequest()->getParam('title'));
        try {
            $oContentPage->deleteFromDB();
            $this->_redirect('/contentPage/');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());

        }
    }


}

