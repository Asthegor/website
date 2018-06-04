<?php

class Country extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new CountryModel();
        $this->returnView($viewmodel->Index());
    }

    protected function add()
    {
        $this->checkLogin();
        $viewmodel = new CountryModel();
        $this->returnView($viewmodel->Add());
    }

    protected function update()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new CountryModel();
        $this->returnView($viewmodel->Update());
    }

    protected function delete()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new CountryModel();
        $this->returnView($viewmodel->Delete());
    }
}

?>