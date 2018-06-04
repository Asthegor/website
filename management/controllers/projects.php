<?php

class Projects extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new ProjectsModel();
        $this->returnView($viewmodel->Index());
    }

    protected function add()
    {
        $this->checkLogin();
        $viewmodel = new ProjectsModel();
        $this->returnView($viewmodel->Add());
    }

    protected function update()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new ProjectsModel();
        $this->returnView($viewmodel->Update());
    }
    protected function delete()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new ProjectsModel();
        $this->returnView($viewmodel->Delete());
    }
}

?>