<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 25.05.12
 * Time: 23:16
 * To change this template use File | Settings | File Templates.
 */
class SearchController extends Zend_Controller_Action
{
    /**
     * @var SM_Menu_Item
     */
    protected $_link;

    public function init()
    {
        $this->_link = SM_Menu_Item::getInstanceByLink('nomaivnopavove_ak');

        $this->view->assign('link', $this->_link->getLink());

        $this->view->assign('linkInfo', $this->_link);
        $this->view->assign('pathway', $this->_link->getPathWay());

        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $query = $this->getRequest()->getParam('query');

            $documentList = SM_Module_Document::search($this->_link, $query);

            $this->view->assign('query', $query);
            $this->view->assign('documentList', $documentList);
        } else {
            $this->_redirect('/');
        }
    }

}
