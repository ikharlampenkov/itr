<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 16.12.11
 * Time: 22:07
 * To change this template use File | Settings | File Templates.
 */
class ShowMenu extends Zend_Controller_Plugin_Abstract
{
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        $view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('View');
        $view->assign('menuList', SM_Menu_Group::getAllInstance());

        $oItem = SM_Menu_Item::getInstanceByLink($request->getParam('link'));
        if ($oItem !== false) {
            $oGroup = $oItem->getGroup();
        } else {
            $oGroup = SM_Menu_Group::getInstanceByLink($request->getParam('link'));
        }

        $view->assign('menuActiveGroup', $oGroup);
        $view->assign('menuActiveItem', $oItem);
    }

}
