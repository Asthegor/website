<?php

class Project extends Controller
{
    protected function display()
    {
        $viewmodel = new ProjectModel();
        $this->returnView($viewmodel->Display());
    }
}

?>