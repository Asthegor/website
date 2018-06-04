<?php

class Content extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new ContentModel();
        $this->returnView($viewmodel->Index());
    }

    protected function add()
    {
        $this->checkLogin();
        $viewmodel = new ContentModel();
        $this->returnView($viewmodel->Add());
    }

    protected function update()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new contentModel();
        $this->returnView($viewmodel->Update());
    }

    protected function delete()
    {
        $this->checkLogin();
        $this->checkId();
        $this->checkLogin();
        $viewmodel = new ContentModel();
        $this->returnView($viewmodel->Delete());
    }
}

?>