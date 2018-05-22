<?php

class Home extends Controller
{
    protected function index()
    {
        if (!isset($_SESSION['language']))
        {
            $_SESSION['language'] = 'FR';
        }
        $viewmodel = new HomeModel();
        $this->returnView($viewmodel->Index());
    }
    protected function en()
    {
        $_SESSION['language'] = 'EN';
        $viewmodel = new HomeModel();
        $this->returnView($viewmodel->Index());
    }
    protected function fr()
    {
        $_SESSION['language'] = 'FR';
        $viewmodel = new HomeModel();
        $this->returnView($viewmodel->Index());
    }
}

?>