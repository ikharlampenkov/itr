<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 22.04.13
 * Time: 23:28
 * To change this template use File | Settings | File Templates.
 */

class ProjectHandbookController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        ///project-handbook/index/handbook/stage/
        $handbook = $this->getRequest()->getParam('handbook', 'branch');

        $this->view->assign('currentHandbook', $handbook);
        $this->view->assign('branchId', $this->getRequest()->getParam('branchId', 0));
    }

}