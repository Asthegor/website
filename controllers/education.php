<?php

class Education extends Controller
{
    protected function index()
    {
        $viewmodel = new EducationModel();
        $this->returnView($viewmodel->Index());
    }
}

?>