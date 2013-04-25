<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 22.04.13
 * Time: 23:28
 * To change this template use File | Settings | File Templates.
 */

class ProjectStageController extends Zend_Controller_Action
{
    public function init()
    {

    }

    public function indexAction()
    {
        if ($this->_request->isXmlHttpRequest()) {

            $this->_helper->layout()->disableLayout();
            Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');


            $stageList = SM_Project_Stage::getAllInstance();

            $html = $this->view->partial(
                "/project-stage/index.phtml", array('stageList' => $stageList)
            );

            $json = Zend_Json::encode(array('html' => $html));

            $this->getResponse()->setBody($json)->setHeader(
                "content-type",
                "application/json", true
            );
        } else {
            $this->view->assign('stageList', SM_Project_Stage::getAllInstance());
        }
    }

    public function addAction()
    {
        $oStage = new SM_Project_Stage();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oStage->setTitle($data['title']);

            try {
                $oStage->insertToDb();

                $this->_redirect('/project-handbook/index/handbook/stage/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('stage', $oStage);
    }

    public function editAction()
    {
        $oStage = SM_Project_Stage::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oStage->setTitle($data['title']);

            try {
                $oStage->updateToDB();

                $this->_redirect('/project-handbook/index/handbook/stage/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('stage', $oStage);
    }

    public function deleteAction()
    {
        $oStage = SM_Project_Stage::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oStage->deleteFromDB();
            $this->_redirect('/project-handbook/index/handbook/stage/');
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }

}