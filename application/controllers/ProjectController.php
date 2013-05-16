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
        $branchId = $this->getRequest()->getParam('branchId', 0);

        if ($branchId != 0) {
            $this->view->assign('branchInfo', SM_Project_Branch::getInstanceById($branchId));
            $this->view->assign('projectList', SM_Project_Project::getAllInstance());
            $this->view->assign('branchList', false);
        } else {
            $this->view->assign('branchList', SM_Project_Branch::getAllInstance());
            $this->view->assign('branchInfo', null);


        }
    }

    public function registerAction()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login/');
        }

        $oProject = new SM_Project_Project();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');

            try {
                if (isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $data['captcha']) {

                    $oProject->setTitle($data['title']);

                    if (isset($data['is_company'])) {
                        $oProject->setIsCompany(1);

                        $oProject->setCompanyTitle($data['company_title']);
                        $oProject->setCompanyContactFio($data['company_contact_fio']);
                        $oProject->setCompanyContactPhone($data['company_contact_phone']);
                        $oProject->setCompanyContactEmail($data['company_contact_email']);
                    } else {
                        $oProject->setIsCompany(0);
                    }

                    $oProject->setDescription($data['description']);
                    $oProject->setResultingProducts($data['resulting_products']);
                    $oProject->setBasicFunction($data['basic_function']);
                    $oProject->setAdditionalFeatures($data['additional_features']);
                    $oProject->setPotentialCustomers($data['potential_customers']);
                    $oProject->setAnalogs($data['analogs']);

                    $oBranch = SM_Project_Branch::getInstanceById($data['branch']);
                    if ($oBranch !== false) {
                        $oProject->setBranch($oBranch);
                    }
                    $oDirection = SM_Project_Direction::getInstanceById($data['direction']);
                    if ($oDirection !== false) {
                        $oProject->setDirection($oDirection);
                    }
                    $oStage = SM_Project_Stage::getInstanceById($data['stage']);
                    if ($oStage !== false) {
                        $oProject->setStage($oStage);
                    }
                    $oRequirements = SM_Project_Requirement::getInstanceById($data['requirements']);
                    if ($oRequirements !== false) {
                        $oProject->setRequirement($oRequirements);
                    }

                    $oProject->setRequirementsText($data['requirements_text']);

                    $oProject->insertToDB();
                    $this->_redirect('/project/view/id/' . $oProject->getId());
                } else {
                    throw new Exception('Введите код с картинки заново');
                }
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('project', $oProject);

        $this->view->assign('branchList', SM_Project_Branch::getAllInstance());
        $this->view->assign('stageList', SM_Project_Stage::getAllInstance());
        $this->view->assign('requirementsList', SM_Project_Requirement::getAllInstance());
    }

    public function viewAction()
    {
        $id = $this->getRequest()->getParam('id', 0);

        $oProject = SM_Project_Project::getInstanceById($id);

        $this->view->assign('project', $oProject);
    }

    public function getDirectionAction()
    {
        if ($this->getRequest()->isPost()) {

            $this->_helper->layout()->disableLayout();
            Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');

            $branchId = $this->getRequest()->getParam('branchId', 0);
            $id = $this->getRequest()->getParam('id', 0);
            $directionList = SM_Project_Direction::getAllInstance($branchId);

            $html = $this->view->partial(
                "/project/_elements/get-direction.phtml",
                array('directionList' => $directionList, 'id' => $id)
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
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login/');
        }


    }

}