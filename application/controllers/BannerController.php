<?php


class BannerController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $this->view->assign('bannerList', SM_Banner_Banner::getAllInstance());
    }

    public function addAction()
    {
        $oBanner = new SM_Banner_Banner();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oBanner->setTitle($data['title']);
            $oBanner->setLink($data['link']);

            try {
                $oBanner->insertToDb();
                $this->_redirect('/banner/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('banner', $oBanner);
    }

    public function editAction()
    {
        $oBanner = SM_Banner_Banner::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oBanner->setTitle($data['title']);
            $oBanner->setLink($data['link']);

            try {
                $oBanner->updateToDb();
                $this->_redirect('/banner/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('banner', $oBanner);
    }

    public function deleteAction()
    {
        $oBanner = SM_Banner_Banner::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oBanner->deleteFromDB();
            $this->_redirect('/banner/');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());

        }
    }

    public function viewplaceAction()
    {
        $this->view->assign('placeList', SM_Banner_Place::getAllInstance());
    }

    public function addplaceAction()
    {
        $oPlace = new SM_Banner_Place();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oPlace->setTitle($data['title']);
            $oPlace->setWidth($data['width']);
            $oPlace->setHeight($data['height']);
            $oPlace->setChangeTime($data['change_time']);

            try {
                $oPlace->insertToDb();
                $this->_redirect('/banner/viewPlace/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('place', $oPlace);
    }

    public function editplaceAction()
    {
        $oPlace = SM_Banner_Place::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oPlace->setTitle($data['title']);
            $oPlace->setWidth($data['width']);
            $oPlace->setHeight($data['height']);
            $oPlace->setChangeTime($data['change_time']);

            try {
                $oPlace->updateToDb();
                $this->_redirect('/banner/viewPlace/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('place', $oPlace);
    }

    public function deleteplaceAction()
    {
        $oPlace = SM_Banner_Place::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oPlace->deleteFromDB();
            $this->_redirect('/banner/viewPlace/');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function placemarkAction()
    {
        $oPlace = SM_Banner_Place::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');

            SM_Banner_PlaceMark::deleteFromDB($oPlace);
            try {
                foreach ($data as $idBanner => $values) {

                    $companyAcl = new SM_Banner_PlaceMark($oPlace);
                    $companyAcl->setBanner(SM_Banner_Banner::getInstanceById($idBanner));

                    $companyAcl->saveToDb();
                }

                $this->_redirect('/banner/viewPlace/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('placeAcl', SM_Banner_PlaceMark::getAllInstance($oPlace));
        $this->view->assign('bannerList', SM_Banner_Banner::getAllInstance());
        $this->view->assign('place', $oPlace);
    }
}

?>