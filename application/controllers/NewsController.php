<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 25.05.12
 * Time: 23:16
 * To change this template use File | Settings | File Templates.
 */
class NewsController extends Zend_Controller_Action
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
        $this->view->assign('newsList', SM_Module_News::getAllInstance($this->_link));
    }

    public function viewnewsAction()
    {
        $oNews = SM_Module_News::getInstanceById($this->getRequest()->getParam('id'));
        $this->view->assign('news', $oNews);
    }

    public function viewAction()
    {
        $this->view->assign('newsList', SM_Module_News::getAllInstance($this->_link));
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


        $oNews = new SM_Module_News();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oNews->setLink($this->_link);
            $oNews->setTitle($data['title']);
            $oNews->setDatePublic($data['date']);
            $oNews->setShortText($data['short_text']);
            $oNews->setFullText($data['full_text']);

            try {
                $oNews->insertToDb();
                $this->_redirect('/news/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('ckeditor', $CKEditor->editor('data[full_text]', $oNews->getFullText()));
        $this->view->assign('news', $oNews);
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

        $oNews = SM_Module_News::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oNews->setTitle($data['title']);
            $oNews->setDatePublic($data['date']);
            $oNews->setShortText($data['short_text']);
            $oNews->setFullText($data['full_text']);

            try {
                $oNews->updateToDB();
                $this->_redirect('/news/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('ckeditor', $CKEditor->editor('data[full_text]', $oNews->getFullText()));
        $this->view->assign('news', $oNews);
    }

    public function deleteAction()
    {
        $oNews = SM_Module_News::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oNews->deleteFromDB();
            $this->_redirect('/news/index/link/' . $this->_link->getLink());
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }

}
