<?php

class Tutorials extends Controller
{
    protected function index()
    {
        $viewmodel = new TutorialsModel();
        $this->returnView($viewmodel->Index());
    }
}

?>