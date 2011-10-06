<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initView()
    {
        // получаем ресурс слоя
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');

        // добавляем поддежрку jQuery
        //$viewRenderer->view->addHelperPath(APPLICATION_PATH . "/views/helpers", 'My_Helper');
        $view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');

        // задаем локальные пути для скриптов и стилей
        ZendX_JQuery::enableView($view);
        $view->jQuery()
                ->enable()
                ->uiEnable()
                ->setLocalPath('/js/jquery-1.6.2.min.js')
                ->setUiLocalPath('/js/jquery-ui-1.8.16.custom.min.js')
                ->addStylesheet('/css/ui-lightness/jquery-ui-1.8.16.custom.css');

        // инициализация doctype
        $view->doctype('XHTML1_STRICT');
        // initialize jquery helper
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        
        // настройка title
        $view->headTitle()->setSeparator(' - ')->headTitle('skylib');
    }


}

