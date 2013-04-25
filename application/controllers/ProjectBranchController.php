<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 22.04.13
 * Time: 23:28
 * To change this template use File | Settings | File Templates.
 */

class ProjectBranchController extends Zend_Controller_Action
{
    public function init()
    {

    }

    public function indexAction()
    {
        if ($this->_request->isXmlHttpRequest()) {

            $this->_helper->layout()->disableLayout();
            Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');


            $branchList = SM_Project_Branch::getAllInstance();
            $directionList = SM_Project_Direction::getAllInstance();

            $html = $this->view->partial(
                "/project-branch/index.phtml", array('branchList' => $branchList, 'directionList' => $directionList)
            );

            $json = Zend_Json::encode(array('html' => $html));

            $this->getResponse()->setBody($json)->setHeader(
                "content-type",
                "application/json", true
            );
        } else {
            $this->view->assign('branchList', SM_Project_Branch::getAllInstance());
            $this->view->assign('directionList', SM_Project_Direction::getAllInstance());
        }
    }

    public function addAction()
    {
        $oBranch = new SM_Project_Branch();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oBranch->setTitle($data['title']);

            try {
                $oBranch->insertToDb();

                $this->_redirect('/project-handbook/index/handbook/branch/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('branch', $oBranch);
    }

    public function editAction()
    {
        $oBranch = SM_Project_Branch::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oBranch->setTitle($data['title']);

            try {
                $oBranch->updateToDB();

                $this->_redirect('/project-handbook/index/handbook/branch/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('branch', $oBranch);
    }

    public function deleteAction()
    {
        $oBranch = SM_Project_Branch::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oBranch->deleteFromDB();
            $this->_redirect('/project-handbook/index/handbook/branch/');
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }

    public function addDirectionAction()
    {
        $branchId = $this->getRequest()->getParam('branchId', 0);

        $oDirection = new SM_Project_Direction();
        if ($branchId != 0) {
            $oDirection->setBranch(SM_Project_Branch::getInstanceById($branchId));
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oDirection->setTitle($data['title']);
            $oDirection->setBranch(SM_Project_Branch::getInstanceById($data['branch_id']));

            try {
                $oDirection->insertToDb();

                $this->_redirect('/project-handbook/index/handbook/branch/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('direction', $oDirection);
        $this->view->assign('branchList', SM_Project_Branch::getAllInstance());
    }

    public function editDirectionAction()
    {
        $oDirection = SM_Project_Direction::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oDirection->setTitle($data['title']);
            $oDirection->setBranch(SM_Project_Branch::getInstanceById($data['branch_id']));

            try {
                $oDirection->updateToDB();

                $this->_redirect('/project-handbook/index/handbook/branch/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('direction', $oDirection);
        $this->view->assign('branchList', SM_Project_Branch::getAllInstance());
    }

    public function deleteDirectionAction()
    {
        $oDirection = SM_Project_Direction::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oDirection->deleteFromDB();
            $this->_redirect('/project-handbook/index/handbook/branch/');
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }
}