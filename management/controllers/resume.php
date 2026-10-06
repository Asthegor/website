<?php

class Resume extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new ResumeModel();
        $profileModel = new ProfileModel();
        $this->returnView(array("viewModel" => $viewmodel->Index(), "profile" => $profileModel->Index()));
    }

    protected function add()
    {
        $this->checkLogin();
        $viewmodel = new ResumeModel();
        $this->returnView($viewmodel->Add());
    }

    protected function update()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new ResumeModel();
        $this->returnView($viewmodel->Update());
    }

    protected function delete()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new ResumeModel();
        $this->returnView($viewmodel->Delete());
    }
}

?>