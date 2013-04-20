<?php

class IndexController extends Zend_Controller_Action
{
    /**
     * @var SM_Menu_Item
     */
    protected $_link;

    public function init()
    {
        $this->_link = SM_Menu_Item::getInstanceByLink('main_page');
        $this->view->assign('link', $this->_link->getLink());

        $this->view->assign('linkInfo', $this->_link);
        $this->view->assign('pathway', $this->_link->getPathWay());
    }

    public function indexAction()
    {
        $oContentPage = SM_Module_ContentPage::getInstanceByTitle('main_page');

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getParam('data');
            $oContentPage->setContent($data['content']);

            try {
                $oContentPage->updateToDb();
                $this->_redirect('/');
            } catch (Exception $e) {
                $this->view->assign('exception_msg', $e->getMessage());
            }
        }

        $this->view->assign('contentPage', $oContentPage);

        /*
        $linkInfo = SM_Menu_Item::getInstanceById(53);
        $this->view->assign('newsList', SM_Module_News::getTopNewsInstance($linkInfo));
        $this->view->linkInfoNews = $linkInfo;

        $documentList = SM_Module_Document::getTopDocument(SM_Menu_Item::getInstanceByLink('nomaivnopavove_ak'));
        $this->view->assign('documentList', $documentList);
        */

        $partnersList = SM_Module_Partners::getAllInstance(null);
        $this->view->assign('partnersList', $partnersList);

        $now = date('Y-m-d');
        //$now = '2013-04-14';
        $eventList = SM_Module_Calendar::getEventByDate($now);

        $this->view->assign('calendarNow', $now);
        $this->view->assign('calendarEventList', $eventList);
    }

    public function refreshCalendarAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->_helper->layout()->disableLayout();
            Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');

            $startDate = $this->getRequest()->getParam('date');
            $direction = $this->getRequest()->getParam('direction', '+1');

            $tempDate = date_parse($startDate);
            if ($direction == '+1') {
                $now = date('Y-m-d', mktime('0', '0', '0', $tempDate['month'], $tempDate['day'] + 1, $tempDate['year']));
            } else {
                $now = date('Y-m-d', mktime('0', '0', '0', $tempDate['month'], $tempDate['day'] - 1, $tempDate['year']));
            }

            $eventList = SM_Module_Calendar::getEventByDate($now);

            $html = $this->view->partial("/index/refresh-calendar.phtml", array('calendarEventList' => $eventList));

            $json = Zend_Json::encode(array('html' => $html, 'calendarNow' => $now, 'dateHtml' => '<b>' . date('d', strtotime($now)) . '</b> ' . date('F, l', strtotime($now))));

            $this->getResponse()->setBody($json)->setHeader(
                "content-type",
                "application/json", true
            );
        }
    }
}

