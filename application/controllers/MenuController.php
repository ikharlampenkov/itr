<?php

class MenuController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->itemList = SM_Menu_Item::getAllInstance();
        $this->view->groupList = SM_Menu_Menu::getAllInstance();
    }

    public function addAction()
    {
        $oMenuItem = new SM_Menu_Item();
        $oMenuItem->setParent(SM_Menu_Menu::getInstanceById(1));
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

            $oGroup = SM_Menu_Menu::getInstanceById($data['group_id']);
            $oMenuItem->setParent($oGroup);

            $oHandler = SM_Menu_Handler::getInstanceById($data['handler_id']);
            $oMenuItem->setHandler($oHandler);

            try {
                $oMenuItem->insertToDb();

                if ($oMenuItem->getHandler()->getController() == 'Contentpage') {
                    $oConPage = new SM_Module_ContentPage();
                    $oConPage->setLink($oMenuItem);
                    $oConPage->setPageTitle($oMenuItem->getLink());
                    $oConPage->setTitle($oMenuItem->getTitle());
                    $oConPage->setContent('');

                    $oConPage->insertToDB();
                }

                $this->_redirect('/menu/');
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('menuItem', $oMenuItem);
        $this->view->handlerList = SM_Menu_Handler::getAllInstance();
        $this->view->groupList = SM_Menu_Menu::getAllInstance();
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

            $oGroup = SM_Menu_Menu::getInstanceById($data['group_id']);
            $oMenuItem->setParent($oGroup);

            $oHandler = SM_Menu_Handler::getInstanceById($data['handler_id']);
            $oMenuItem->setHandler($oHandler);

            try {
                $oMenuItem->updateToDb();

                if ($oMenuItem->getHandler() !== null && $oMenuItem->getHandler()->getController() == 'Contentpage') {

                    $tempPage = SM_Module_ContentPage::getInstanceByTitle($oMenuItem->getLink());
                    if ($tempPage instanceof SM_Module_ContentPage) {
                        $tempPage->setTitle($oMenuItem->getTitle());
                        $tempPage->updateToDB();
                    } else {
                        $oConPage = new SM_Module_ContentPage();
                        $oConPage->setLink($oMenuItem);
                        $oConPage->setPageTitle($oMenuItem->getLink());
                        $oConPage->setTitle($oMenuItem->getTitle());
                        $oConPage->setContent('');

                        $oConPage->insertToDB();
                    }
                }


                $this->_redirect('/menu/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('menuItem', $oMenuItem);
        $this->view->handlerList = SM_Menu_Handler::getAllInstance();
        $this->view->groupList = SM_Menu_Menu::getAllInstance();
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

    public function addgroupAction()
    {
        $oMenuGroup = new SM_Menu_Menu();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oMenuGroup->setTitle($data['title']);
            $oMenuGroup->setCode($data['title']);

            if (!empty($data['handler_id'])) {
                $oMenuGroup->setHandler(SM_Menu_Handler::getInstanceById($data['handler_id']));
            } else {
                $oMenuGroup->setHandler(null);
            }

            try {
                $oMenuGroup->insertToDb();

                if ($oMenuGroup->getHandler() !== null && $oMenuGroup->getHandler()->getController() == 'Contentpage') {
                    $tempPage = SM_Module_ContentPage::getInstanceByTitle($oMenuGroup->getCode());
                    if ($tempPage instanceof SM_Module_ContentPage) {
                        $tempPage->setTitle($oMenuGroup->getTitle());
                        $tempPage->updateToDB();
                    } else {
                        $oConPage = new SM_Module_ContentPage();
                        $oConPage->setLink($oMenuGroup);
                        $oConPage->setPageTitle($oMenuGroup->getCode());
                        $oConPage->setTitle($oMenuGroup->getTitle());
                        $oConPage->setContent('');

                        $oConPage->insertToDB();
                    }
                }

                $this->_redirect('/menu/');
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('menuGroup', $oMenuGroup);
        $this->view->handlerList = SM_Menu_Handler::getAllInstance();
    }

    public function editgroupAction()
    {
        $oMenuGroup = SM_Menu_Menu::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oMenuGroup->setTitle($data['title']);
            $oMenuGroup->setCode($data['link']);

            if (!empty($data['handler_id'])) {
                $oMenuGroup->setHandler(SM_Menu_Handler::getInstanceById($data['handler_id']));
            } else {
                $oMenuGroup->setHandler(null);
            }

            try {
                $oMenuGroup->updateToDb();

                if ($oMenuGroup->getHandler() !== null && $oMenuGroup->getHandler()->getController() == 'Contentpage') {

                    $tempPage = SM_Module_ContentPage::getInstanceByTitle($oMenuGroup->getCode());
                    if ($tempPage instanceof SM_Module_ContentPage) {
                        $tempPage->setTitle($oMenuGroup->getTitle());
                        $tempPage->updateToDB();
                    } else {
                        $oConPage = new SM_Module_ContentPage();
                        $oConPage->setLink($oMenuGroup);
                        $oConPage->setPageTitle($oMenuGroup->getCode());
                        $oConPage->setTitle($oMenuGroup->getTitle());
                        $oConPage->setContent('');

                        $oConPage->insertToDB();
                    }
                }

                $this->_redirect('/menu/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('menuGroup', $oMenuGroup);
        $this->view->handlerList = SM_Menu_Handler::getAllInstance();
    }

    public function deletegroupAction()
    {
        $oMenuGroup = SM_Menu_Menu::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oMenuGroup->deleteFromDB();
            $this->_redirect('/menu/');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());

        }
    }


}

