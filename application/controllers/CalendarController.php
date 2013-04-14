<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 25.05.12
 * Time: 23:16
 * To change this template use File | Settings | File Templates.
 */
class CalendarController extends Zend_Controller_Action
{
    /**
     * @var SM_Menu_Item
     */
    protected $_link;

    /**
     * @var SM_Module_CalendarCategory|null
     */
    protected $_category = null;

    public function init()
    {
        $this->_link = SM_Menu_Item::getInstanceByLink($this->getRequest()->getParam('link'));
        $this->view->assign('link', $this->_link->getLink());
        $this->view->assign('linkInfo', $this->_link);
        $this->view->assign('pathway', $this->_link->getPathWay());

        $categoryId = $this->getRequest()->getParam('categoryId', '');
        if ($categoryId != '' && $categoryId != 0) {
            $this->_category = SM_Module_CalendarCategory::getInstanceById($categoryId);
        }

        $this->view->assign('category', $this->_category);

        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->assign('calendarList', SM_Module_Calendar::getAllInstance($this->_link, $this->_category));
        $this->view->assign('categoryList', SM_Module_CalendarCategory::getAllInstance());
    }

    public function viewcalendarAction()
    {
        $oCalendar = SM_Module_Calendar::getInstanceById($this->getRequest()->getParam('id'));
        $this->view->assign('calendar', $oCalendar);

        $this->view->assign('categoryList', SM_Module_CalendarCategory::getAllInstance());
    }

    public function viewAction()
    {
        $this->view->assign('calendarList', SM_Module_Calendar::getAllInstance($this->_link, $this->_category));
        $this->view->assign('categoryList', SM_Module_CalendarCategory::getAllInstance());
    }

    public function addAction()
    {
        $oCalendar = new SM_Module_Calendar();
        $oCalendar->setCategory($this->_category);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oCalendar->setLink($this->_link);
            $oCalendar->setTitle($data['title']);
            $oCalendar->setDateEvent($data['date']);
            $oCalendar->setTimeEvent($data['time']);
            $oCalendar->setPlace($data['place']);
            $oCalendar->setShortText($data['short_text']);
            $oCalendar->setFullText($data['full_text']);

            if ($data['category_id'] != 'null') {
                $oCalendar->setCategory(SM_Module_CalendarCategory::getInstanceById($data['category_id']));
            } else {
                $oCalendar->setCategory(null);
            }

            try {
                $oCalendar->insertToDb();
                if ($this->_category != null) {
                    $this->_redirect('/calendar/index/link/' . $this->_link->getLink() . '/categoryId/' . $this->_category->getId());
                } else {
                    $this->_redirect('/calendar/index/link/' . $this->_link->getLink());
                }
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('calendar', $oCalendar);
        $this->view->assign('categoryList', SM_Module_CalendarCategory::getAllInstance());
    }

    public function editAction()
    {
        $oCalendar = SM_Module_Calendar::getInstanceById($this->getRequest()->getParam('id'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oCalendar->setTitle($data['title']);
            $oCalendar->setDateEvent($data['date']);
            $oCalendar->setTimeEvent($data['time']);
            $oCalendar->setPlace($data['place']);
            $oCalendar->setShortText($data['short_text']);
            $oCalendar->setFullText($data['full_text']);

            if ($data['category_id'] != 'null') {
                $oCalendar->setCategory(SM_Module_CalendarCategory::getInstanceById($data['category_id']));
            } else {
                $oCalendar->setCategory(null);
            }

            try {
                $oCalendar->updateToDB();
                if ($this->_category != null) {
                    $this->_redirect('/calendar/index/link/' . $this->_link->getLink() . '/categoryId/' . $this->_category->getId());
                } else {
                    $this->_redirect('/calendar/index/link/' . $this->_link->getLink());
                }
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('calendar', $oCalendar);
        $this->view->assign('categoryList', SM_Module_CalendarCategory::getAllInstance());
    }

    public function deleteAction()
    {
        $oCalendar = SM_Module_Calendar::getInstanceById($this->getRequest()->getParam('id'));
        try {
            $oCalendar->deleteFromDB();
            $this->_redirect('/calendar/index/link/' . $this->_link->getLink());
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }

    public function addcategoryAction()
    {
        $oCalendarCategory = new SM_Module_CalendarCategory();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oCalendarCategory->setTitle($data['title']);

            try {
                $oCalendarCategory->insertToDb();
                $this->_redirect('/calendar/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('calendarCategory', $oCalendarCategory);

    }

    public function editcategoryAction()
    {
        $oCalendarCategory = SM_Module_CalendarCategory::getInstanceById($this->getRequest()->getParam('categoryId'));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oCalendarCategory->setTitle($data['title']);

            try {
                $oCalendarCategory->updateToDB();
                $this->_redirect('/calendar/index/link/' . $this->_link->getLink());
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }

        }

        $this->view->assign('calendarCategory', $oCalendarCategory);
    }

    public function deletecategoryAction()
    {
        $oCalendarCategory = SM_Module_CalendarCategory::getInstanceById($this->getRequest()->getParam('categoryId'));
        try {
            $oCalendarCategory->deleteFromDB();
            $this->_redirect('/calendar/index/link/' . $this->_link->getLink());
        } catch (Exception $e) {
            $this->view->assign('exception_msg', $e->getMessage());
        }
    }

}
