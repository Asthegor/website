<?php
abstract class Controller
{
    protected $request;
    protected $action;

    public function __construct($action, $request)
    {
        $this->action = $action;
        $this->request = $request;
    }

    public function executeAction()
    {
        return $this->{$this->action}();
    }

    protected function returnView($viewModel, $fullView = true)
    {
        $view = 'views/'.strtolower(get_class($this)).'/'.$this->action.'.php';
        if($fullView)
        {
            require('views/main.php');
        }
        else
        {
            require($view);
        }
    }

    protected function checkLogin()
    {
        if (!isset($_SESSION['is_logged_in']))
        {
            $usr = new Users();
            $usr->logout(false);
            header('Location: '.ROOT_MNGT);
        }
    }
}
?>