<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 22.04.13
 * Time: 23:28
 * To change this template use File | Settings | File Templates.
 */

class ProjectRequirementsController extends Zend_Controller_Action
{
    public function init()
    {

    }

    public function indexAction()
    {
        if ($this->_request->isXmlHttpRequest()) {

            $this->_helper->layout()->disableLayout();
            Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');


            $requirementList = SM_Project_Requirement::getAllInstance();

            $html = $this->view->partial(
                "/project-requirements/index.phtml", array('requirementList' => $requirementList)
            );

            $json = Zend_Json::encode(array('html' => $html));

            $this->getResponse()->setBody($json)->setHeader(
                "content-type",
                "application/json", true
            );
        } else {
            $this->view->assign('requirementList', SM_Project_Requirement::getAllInstance());
        }
    }

    public function addAction()
    {
        $oRequirement = new SM_Project_Requirement();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oRequirement->setTitle($data['title']);

            try {
                $oRequirement->insertToDb();

                $this->_redirect('/project-handbook/index/handbook/requirement/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('requirement', $oRequirement);
    }

    public function editAction()
    {
        $oRequirement = SM_Project_Requirement::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oRequirement->setTitle($data['title']);

            try {
                $oRequirement->updateToDB();

                $this->_redirect('/project-handbook/index/handbook/requirement/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('requirement', $oRequirement);
    }

    public function deleteAction()
    {
        $oRequirement = SM_Project_Requirement::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oRequirement->deleteFromDB();
            $this->_redirect('/project-handbook/index/handbook/requirement/');
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }

}