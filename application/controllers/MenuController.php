<?php

class MenuController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->itemList = SM_Menu_Item::getAllInstance(null);
        $this->view->menuList = SM_Menu_Menu::getAllInstance();
    }

    public function addAction()
    {
        $oMenuItem = new SM_Menu_Item();
        $oMenuItem->setParent(null);
        $oMenuItem->setHandler(SM_Menu_Handler::getInstanceById(1));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oMenuItem->setTitle($data['title']);
            $oMenuItem->setLink($data['title']);

            if (isset($data['is_visible'])) {
                $oMenuItem->setIsVisible(1);
            } else {
                $oMenuItem->setIsVisible(0);
            }


            if ($data['parent_id'] != 'null') {
                $oParent = SM_Menu_Menu::getInstanceById($data['parent_id']);
                $oMenuItem->setParent($oParent);
            } else {
                $oMenuItem->setParent(null);
            }

            $oHandler = SM_Menu_Handler::getInstanceById($data['handler_id']);
            $oMenuItem->setHandler($oHandler);

            if (isset($data['menu'])) {
                $oMenuItem->setMenuList($data['menu']);
            }

            try {
                $oMenuItem->insertToDb();

                $this->_redirect('/menu/');
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('menuItem', $oMenuItem);
        $this->view->handlerList = SM_Menu_Handler::getAllInstance();
        $this->view->menuList = SM_Menu_Menu::getAllInstance();
        $this->view->parentList = SM_Menu_Item::getAllInstance(null);
    }

    public function editAction()
    {
        $oMenuItem = SM_Menu_Item::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oMenuItem->setTitle($data['title']);
            $oMenuItem->setLink($data['link']);

            if (isset($data['is_visible'])) {
                $oMenuItem->setIsVisible(1);
            } else {
                $oMenuItem->setIsVisible(0);
            }

            if ($data['parent_id'] != 'null') {
                $oParent = SM_Menu_Menu::getInstanceById($data['parent_id']);
                $oMenuItem->setParent($oParent);
            } else {
                $oMenuItem->setParent(null);
            }

            $oHandler = SM_Menu_Handler::getInstanceById($data['handler_id']);
            $oMenuItem->setHandler($oHandler);

            if (isset($data['menu'])) {
                $oMenuItem->setMenuList($data['menu']);
            }

            try {
                $oMenuItem->updateToDb();
                $this->_redirect('/menu/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('menuItem', $oMenuItem);
        $this->view->handlerList = SM_Menu_Handler::getAllInstance();
        $this->view->menuList = SM_Menu_Menu::getAllInstance();
        $this->view->parentList = SM_Menu_Item::getAllInstance(null);
    }

    public function deleteAction()
    {
        $oMenuItem = SM_Menu_Item::getInstanceById($this->getRequest()->getParam('id'));
        try {
            if ($oMenuItem->getHandler()->getController() == 'Contentpage') {
                $oConPage = SM_Module_ContentPage::getInstanceByTitle($oMenuItem->getLink());
                $oConPage->deleteFromDB();
            }

            $oMenuItem->deleteFromDB();
            $this->_redirect('/menu/');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());

        }
    }

    public function addmenuAction()
    {
        $oMenuMenu = new SM_Menu_Menu();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oMenuMenu->setTitle($data['title']);
            $oMenuMenu->setCode($data['title']);

            try {
                $oMenuMenu->insertToDb();
                $this->_redirect('/menu/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('menuMenu', $oMenuMenu);
    }

    public function editmenuAction()
    {
        $oMenuMenu = SM_Menu_Menu::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oMenuMenu->setTitle($data['title']);
            $oMenuMenu->setCode($data['code']);

            try {
                $oMenuMenu->updateToDb();
                $this->_redirect('/menu/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('menuMenu', $oMenuMenu);
    }

    public function deletemenuAction()
    {
        $oMenuMenu = SM_Menu_Menu::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oMenuMenu->deleteFromDB();
            $this->_redirect('/menu/');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());

        }
    }


}

