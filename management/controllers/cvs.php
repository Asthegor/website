<?php

class CVs extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new CvsModel();
        $this->returnView($viewmodel->Index());
    }
}

?>