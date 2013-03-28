<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 16.12.11
 * Time: 22:07
 * To change this template use File | Settings | File Templates.
 */
class ShowNews extends Zend_Controller_Plugin_Abstract
{
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        $view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('View');

        //$linkInfo = SM_Menu_Item::getInstanceById(53);
        $view->newsListMain = SM_Module_News::getAllTopNewsInstance();
        //$view->linkInfoNewsMain = $linkInfo;
    }

}
