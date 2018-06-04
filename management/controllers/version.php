<?php

class Version extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new VersionModel();
        $this->returnView($viewmodel->Index());
    }

    protected function update()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new VersionModel();
        $this->returnView($viewmodel->Update());
    }

    protected function delete()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new VersionModel();
        $this->returnView($viewmodel->Delete());
    }
}

?>