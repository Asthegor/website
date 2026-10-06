<?php

class Tutorial extends Controller
{
    protected function index()
    {
        
        $viewmodel = new TutorialModel();
        $index = $viewmodel->Index();
        if(is_null($index) || !is_array($index))
        {
            $this->returnToPage("tutorials");
            return;
        }
        $this->returnView($index);
    }
}

?>