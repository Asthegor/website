<?php

class Files extends Controller
{
    protected function index()
    {
        $this->returnToPage("");
        return;

        $viewmodel = new HomeModel();
        $this->returnView($viewmodel->Index());
    }
}

?>