<?php

class Resume extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new ResumeModel();
        $this->returnView($viewmodel->Index());
    }
}

?>