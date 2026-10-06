<?php

class MainController
{
    private $controller;
    private $action;
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
        if (!isset($request) || !isset($this->request['controller']) || $this->request['controller'] == "")
        {
            $this->controller = 'home';
        }
        else
        {
            $this->controller = $this->request['controller'];
        }
        if (!isset($request) || !in_array('action', $this->request) || $this->request['action'] == "")
        {
            $this->action = 'index';
        }
        else
        {
            $this->action = $this->request['action'];
        }
    }
    public function createController()
    {
        // Check Class
        if(class_exists($this->controller))
        {
            $parents = class_parents($this->controller);
            //Check Extend
            if(in_array("Controller", $parents))
            {
                if (strtolower($this->controller) === 'project')
                {
                    $this->request['action'] = 'index';
                    $this->request['slug'] = $this->action;
                    $this->action = 'index';
                }
                if(method_exists($this->controller, $this->action))
                {
                    return new $this->controller($this->action, $this->request);
                }
            }
        }
        header('Location: '.ROOT_URL);
    }
}
?>