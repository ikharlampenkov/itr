<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initView()
    {
        //  Инициализируем создание шаблонизатора
        $this->bootstrap('Layout');
        $layout = $this->getResource('Layout');

        //  Получаем от Шаблонизатора Виды.
        $view = $layout->getView();

        //  Устанавливаем базовый путь до шаблонов.
        $view->setBasePath(APPLICATION_PATH . "/layouts");

        //  Устанавливаем кодировку вывода.
        $view->setEncoding('UTF-8');


        //  Возвращаем бутстраперу Вид
        return $view;
    }

    protected function _initAutoLoader()
    {
        $auto = Zend_Loader_Autoloader::getInstance();
        $auto->registerNamespace('TM');
        $auto->registerNamespace('SM');
        $auto->registerNamespace('StdLib');
    }

    protected function _initConfig()
    {
        Zend_Registry::set('production', new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production'));
    }

    protected function _initLog()
    {
        // Получаем опции
        $options = $this->getOptions();

        $o_log = new StdLib_Log();
        $o_log->setLogLevel($options['log']['level']);

        $db = StdLib_DB::getInstance();
        $db->debug = $options['db']['debug'];
    }

    protected function _initAuth()
    {
        $auth = Zend_Auth::getInstance();
        $data = $auth->getStorage()->read();

        if (!isset($data->role)) {
            $storage_data = new stdClass();
            $storage_data->id = 0;
            $storage_data->login = 'guest';
            $storage_data->token = '';
            $storage_data->role = 'guest';
            $auth->getStorage()->write($storage_data);

            $view = $this->getResource('View');
            $view->authUser = 'guest';
            $view->authUserRole = 'guest';
        } else {
            $view = $this->getResource('View');
            $view->authUser = $data->login;
            $view->authUserRole = $data->role;
        }
    }

    protected function _initAcl()
    {
        /*
        Zend_Loader::loadClass('TM_Acl_Acl');
        Zend_Loader::loadClass('CheckAccess');
        Zend_Controller_Front::getInstance()->registerPlugin(new CheckAccess());

        $view = $this->getResource('View');
        $view->getEngine()->loadPlugin('smarty_block_if_allowed');
        $view->getEngine()->loadPlugin('smarty_block_if_object_allowed');
        return new TM_Acl_Acl();
        */
    }

    protected function _initViewParam()
    {
        Zend_Loader::loadClass('ShowMenu');
        Zend_Controller_Front::getInstance()->registerPlugin(new ShowMenu());

        Zend_Loader::loadClass('ShowBanner');
        Zend_Controller_Front::getInstance()->registerPlugin(new ShowBanner());

        Zend_Loader::loadClass('ShowPhone');
        Zend_Controller_Front::getInstance()->registerPlugin(new ShowPhone());
        
        Zend_Loader::loadClass('ShowNews');
        Zend_Controller_Front::getInstance()->registerPlugin(new ShowNews());
    }

    protected function _initRoute()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();

        $oMenuItemList = SM_Menu_Item::getAllInstance(null);
        foreach ($oMenuItemList as $menuItem) {
            $menuItem->getRoute($router);
        }
    }


}
