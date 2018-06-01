<?php

class Experiences extends Controller
{
    protected function index()
    {
        $viewmodel = new ExperiencesModel();
        $this->returnView($viewmodel->Index());
    }
}

?>