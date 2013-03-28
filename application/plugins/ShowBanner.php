<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 16.12.11
 * Time: 22:07
 * To change this template use File | Settings | File Templates.
 */
class ShowBanner extends Zend_Controller_Plugin_Abstract
{
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        $view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('View');

        $oPlace = SM_Banner_Place::getInstanceById(1);
        $view->assign('bannerListMain', SM_Banner_PlaceMark::getAllInstance($oPlace));
        $view->assign('mainPlace', $oPlace);
    }
}
