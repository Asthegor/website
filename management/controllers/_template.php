<?php

class _Template extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new _TemplateModel();
        $this->returnView($viewmodel->Index());
    }
}

?>