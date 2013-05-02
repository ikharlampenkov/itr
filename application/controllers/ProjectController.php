<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 22.04.13
 * Time: 23:17
 * To change this template use File | Settings | File Templates.
 */

class ProjectController extends Zend_Controller_Action
{
    public function init()
    {

    }

    public function indexAction()
    {

    }

    public function registerAction()
    {
        $oProject = new SM_Project_Project();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');

            if (isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $data['captcha']) {

            }

        }

        $this->view->assign('project', $oProject);

        $this->view->assign('branchList', SM_Project_Branch::getAllInstance());
        $this->view->assign('stageList', SM_Project_Stage::getAllInstance());
        $this->view->assign('requirementsList', SM_Project_Requirement::getAllInstance());
    }

    public function getDirectionAction()
    {
        if ($this->getRequest()->isPost()) {

            $this->_helper->layout()->disableLayout();
            Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');

            $branchId = $this->getRequest()->getParam('branchId', 0);
            $directionList = SM_Project_Direction::getAllInstance($branchId);

            $html = $this->view->partial(
                "/project/_elements/get-direction.phtml",
                array('directionList' => $directionList)
            );

            $json = Zend_Json::encode(array('html' => $html));

            $this->getResponse()->setBody($json)->setHeader(
                "content-type",
                "application/json", true
            );
        }
    }

    public function developAction()
    {

    }

}