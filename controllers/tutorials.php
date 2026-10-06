<?php

class Tutorials extends Controller
{
    protected function index()
    {
        $viewmodel = new TutorialsModel();
        $index = $viewmodel->Index();
        if(is_null($index) || !is_array($index))
        {
            $this->returnToPage("");
            return;
        }
        $this->returnView($index);
    }
}

?>