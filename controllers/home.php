<?php

class Home extends Controller
{
    protected function index()
    {
        if (!isset($_SESSION['language']))
        {
            $_SESSION['language'] = 'FR';
        }
        Profiling::StartChrono('HomeModel');
        $viewmodel = new HomeModel();
        Profiling::EndChrono('HomeModel');
        Profiling::StartChrono('HomeModelIndex');
        $index = $viewmodel->Index();
        Profiling::EndChrono('HomeModelIndex');
        Profiling::StartChrono('Home_ReturnView');
        $this->returnView($index);
        Profiling::EndChrono('Home_ReturnView');
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