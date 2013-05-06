<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 06.05.13
 * Time: 22:52
 * To change this template use File | Settings | File Templates.
 */

class Views_Helpers_IfAllowed extends Zend_View_Helper_Abstract
{
    public function ifAllowed($resource, $privilege = 'show')
    {
        return true;
    }

}