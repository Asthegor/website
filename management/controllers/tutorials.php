<?php

class Tutorials extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new TutorialsModel();
        $this->returnView($viewmodel->Index());
    }
}

?>