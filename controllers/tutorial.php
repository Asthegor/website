<?php

class Tutorial extends Controller
{
    protected function display()
    {
        $viewmodel = new TutorialModel();
        $this->returnView($viewmodel->Display());
    }
}

?>