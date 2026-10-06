<?php

class Tests extends Controller
{
    protected function index()
    {
        $this->returnToPage("");
        return;
        $viewmodel = new TestsModel();
        $this->returnView($viewmodel->Index());
    }
}

?>