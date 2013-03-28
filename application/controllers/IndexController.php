<?php

class IndexController extends Zend_Controller_Action
{
    /**
     * @var SM_Menu_Item
     */
    protected $_link;

    public function init()
    {
        $this->_link = SM_Menu_Item::getInstanceByLink('main_page');
        $this->view->assign('link', $this->_link->getLink());

        $this->view->assign('linkInfo', $this->_link);
        $this->view->assign('pathway', $this->_link->getPathWay());
    }

    public function indexAction()
    {
        $oContentPage = SM_Module_ContentPage::getInstanceByTitle('main_page');

        include_once Zend_Registry::get('production')->editor->path . 'ckeditor/ckeditor.php';
        include_once Zend_Registry::get('production')->editor->path . 'ckfinder/ckfinder.php';

        $CKEditor = new CKEditor();
        $CKEditor->basePath = '/ckeditor/';
        $CKEditor->returnOutput = true;

        $ckFinder = new CKFinder();
        $ckFinder->BasePath = '/ckfinder/';
        $ckFinder->SetupCKEditorObject($CKEditor);


        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oContentPage->setContent($data['content']);

            try {
                $oContentPage->updateToDb();
                $this->_redirect('/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('ckeditor', $CKEditor->editor('data[content]', $oContentPage->getContent()));
        $this->view->assign('contentPage', $oContentPage);

        $linkInfo = SM_Menu_Item::getInstanceById(53);
        $this->view->assign('newsList', SM_Module_News::getTopNewsInstance($linkInfo));
        $this->view->linkInfoNews = $linkInfo;

        $documentList = SM_Module_Document::getTopDocument(SM_Menu_Item::getInstanceByLink('nomaivnopavove_ak'));
        $this->view->assign('documentList', $documentList);
    }


}

