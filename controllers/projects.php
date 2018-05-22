<?php

class Projects extends Controller
{
    protected function index()
    {
        $viewmodel = new ProjectsModel();
        $this->returnView($viewmodel->Index());
    }
}

?>