<?php

class Configs extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new ConfigModel();
        $configs = $viewmodel->Index();
        $viewlabelmodel = new LabelModel();
        $labels = $viewlabelmodel->Index();
        $this->returnView(array("viewModelConfigs"=>$configs,"viewModelLabels"=>$labels));
    }

    protected function add()
    {
        $this->checkLogin();
        $viewmodel = new ConfigModel();
        $this->returnView($viewmodel->Add());
    }

    protected function update()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new ConfigModel();
        $this->returnView($viewmodel->Update());
    }

    protected function delete()
    {
        $this->checkLogin();
        $this->checkId();
        $viewmodel = new ConfigModel();
        $this->returnView($viewmodel->Delete());
    }
}

?>