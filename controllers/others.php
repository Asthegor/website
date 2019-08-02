<?php

class Others extends Controller
{
    protected function index()
    {
        $viewmodel = new OthersModel();
        $this->returnView($viewmodel->Index());
    }
}

?>