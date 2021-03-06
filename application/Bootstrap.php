<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected $_locale
        = array(
            Zend_Validate_Alnum::NOT_ALNUM                  => 'Введенное значение "%value%" неправильное. Разрешены только латинские символы и цифры',
            Zend_Validate_Alnum::STRING_EMPTY               => 'Поле не может быть пустым. Заполните его, пожалуйста',

            Zend_Validate_Alpha::NOT_ALPHA                  => 'Введите в это поле только латинские символы',
            Zend_Validate_Alpha::STRING_EMPTY               => 'Поле не может быть пустым. Заполните его, пожалуйста',

            //Zend_Validate_Barcode_UpcA::INVALID => '"%value% неправильный UPC-A штрих-код"',
            //Zend_Validate_Barcode_UpcA::INVALID_LENGTH => 'Неправильное значение "%value%". Введите 12 символов',

            //Zend_Validate_Barcode_Ean13::INVALID => '"%value% неправильный EAN-13 штрих-код',
            //Zend_Validate_Barcode_Ean13::INVALID_LENGTH => 'Неправильное значение "%value%". Введите 13 символов',

            Zend_Validate_Between::NOT_BETWEEN              => '"%value%" не находится между "%min%" и "%max%", включительно',
            Zend_Validate_Between::NOT_BETWEEN_STRICT       => '"%value%" не находится строго между "%min%" и "%max%"',

            Zend_Validate_Ccnum::LENGTH                     => '"%value%" должно быть численным значением от 13 до 19 цифр длинной',
            Zend_Validate_Ccnum::CHECKSUM                   => 'Подсчёт контрольной суммы неудался. Значение "%value%" неверно',

            //Zend_Validate_Date::NOT_YYYY_MM_DD => '"%value%" не подходит под формат год-месяц-день(напр. 2008-11-03)',
            Zend_Validate_Date::INVALID                     => '"%value%" - неверная дата',
            Zend_Validate_Date::FALSEFORMAT                 => '"%value%" - не подходит по формату',

            Zend_Validate_Digits::NOT_DIGITS                => 'Значение "%value%" неправильное. Введите только цифры',
            Zend_Validate_Digits::STRING_EMPTY              => 'Поле не может быть пустым. Заполните его, пожалуйста',

            Zend_Validate_EmailAddress::INVALID             => '"%value%" неправильный адрес електронной почты. Введите его в формате имя@домен',
            Zend_Validate_EmailAddress::INVALID_HOSTNAME    => '"%hostname%" неверный домен для адреса "%value%"',
            Zend_Validate_EmailAddress::INVALID_MX_RECORD   => 'Домен "%hostname%" не имеет MX-записи об адресе "%value%"',
            Zend_Validate_EmailAddress::DOT_ATOM            => '"%localPart%" не соответствует формату dot-atom',
            Zend_Validate_EmailAddress::QUOTED_STRING       => '"%localPart%" не соответствует формату указанной строки',
            Zend_Validate_EmailAddress::INVALID_LOCAL_PART  => '"%localPart%" не правильное имя для адреса "%value%", вводите адрес вида имя@домен',
            Zend_Validate_EmailAddress::INVALID_FORMAT      => "Вы ввели неверный e-mail адрес. Введите e-mail в формате example@domain.com",

            Zend_Validate_Float::NOT_FLOAT                  => '"%value%" не является дробным числом',

            Zend_Validate_GreaterThan::NOT_GREATER          => '"%value%" не превышает "%min%"',

            Zend_Validate_Hex::NOT_HEX                      => '"%value%" содержит в себе не только шестнадцатеричные символы',

            Zend_Validate_Hostname::IP_ADDRESS_NOT_ALLOWED  => '"%value%" - это IP-адрес, но IP-адреса не разрешены ',
            Zend_Validate_Hostname::UNKNOWN_TLD             => '"%value%" - это DNS имя хоста, но оно не дожно быть из TLD-списка',
            Zend_Validate_Hostname::INVALID_DASH            => '"%value%" - это DNS имя хоста, но знак "-" находится в неправильном месте',
            Zend_Validate_Hostname::INVALID_HOSTNAME_SCHEMA => '"%value%" - это DNS имя хоста, но оно не соответствует TLD для TLD "%tld%"',
            Zend_Validate_Hostname::UNDECIPHERABLE_TLD      => '"%value%" - это DNS имя хоста. Не удаётся извлечь TLD часть',
            Zend_Validate_Hostname::INVALID_HOSTNAME        => '"%value%" - не соответствует ожидаемой структуре для DNS имени хоста',
            Zend_Validate_Hostname::INVALID_LOCAL_NAME      => '"%value%" - адрес является недопустимым локальным сетевым адресом',
            Zend_Validate_Hostname::LOCAL_NAME_NOT_ALLOWED  => '"%value%" - адрес является сетевым расположением, но локальные сетевые адреса не разрешены',

            Zend_Validate_Identical::NOT_SAME               => 'Значения не совпадают',
            Zend_Validate_Identical::MISSING_TOKEN          => 'Не было введено значения для проверки на идентичность',

            Zend_Validate_InArray::NOT_IN_ARRAY             => '"%value%" не найдено в перечисленных допустимых значениях',

            Zend_Validate_Int::NOT_INT                      => '"%value%" не является целочисленным значением',

            Zend_Validate_Ip::NOT_IP_ADDRESS                => '"%value%" не является правильным IP-адресом',

            Zend_Validate_LessThan::NOT_LESS                => '"%value%" не меньше, чем "%max%"',

            Zend_Validate_NotEmpty::IS_EMPTY                => 'Введённое значение пустое, заполните поле, пожалуйста',

            Zend_Validate_Regex::NOT_MATCH                  => 'Значение "%value%" не подходит под шаблон регулярного выражения "%pattern%"',

            Zend_Validate_StringLength::TOO_SHORT           => 'Длина введённого значения "%value%", меньше чем %min% симв.',
            Zend_Validate_StringLength::TOO_LONG            => 'Длина введённого значения "%value%", больше чем %max% симв.'
        );

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
        $auto->registerNamespace('Twitter');

    }

    protected function _initConfig()
    {
        Zend_Registry::set('production', new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production'));

        $translate = new Zend_Translate(
            'array',
            $this->_locale,
            'ru'
        );
        Zend_Validate::setDefaultTranslator($translate);
    }

    protected function _initDb()
    {
        $config = Zend_Registry::get('production');
        Zend_Registry::set('db', Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params));
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
        $data = $auth->getIdentity();

        if ($data == null) {
            /*
            $storage_data = new stdClass();
            $storage_data->id = 0;
            $storage_data->login = 'guest';
            $storage_data->token = '';
            $storage_data->role = 'guest';
            $auth->getStorage()->write($storage_data);
            */

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

        $view = $this->getResource('View');
        $view->addHelperPath(APPLICATION_PATH . "/views/helpers/", 'View_Helpers');
        //Zend_Loader::loadClass('Views_Helpers_IfAllowed');
        //$helper = new Views_Helpers_IfAllowed();
        //$view->registerHelper($helper, 'ifAllowed');
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

        Zend_Loader::loadClass('SetViewParam');
        Zend_Controller_Front::getInstance()->registerPlugin(new SetViewParam());
    }

    protected function _initRoute()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();

        $oMenuItemList = SM_Menu_Item::getAllInstance(null);
        foreach ($oMenuItemList as $menuItem) {
            $menuItem->getRoute($router);
            if ($menuItem->hasChild()) {
                $this->prepareChildRoute($menuItem->getChild(), $router);
            }
        }
    }

    private function prepareChildRoute($childList, $router)
    {
        foreach ($childList as $menuItem) {
            $menuItem->getRoute($router);
            if ($menuItem->hasChild()) {
                $this->prepareChildRoute($menuItem->getChild(), $router);
            }
        }
    }


}
