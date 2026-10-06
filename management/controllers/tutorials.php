<?php

class Tutorials extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new TutorialsModel();
        $this->returnView($viewmodel->Index());
    }

    protected function add()
    {
        $this->checkLogin();
        $viewmodel = new TutorialsModel();
        $this->returnView($viewmodel->Add());
    }

    protected function update()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new TutorialsModel();
        $this->returnView($viewmodel->Update());
    }
    protected function delete()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new TutorialsModel();
        $this->returnView($viewmodel->Delete());
    }
}

?>