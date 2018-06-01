<?php

class Contact extends Controller
{
    protected function index()
    {
        $viewmodel = new ContactModel();
        $this->returnView($viewmodel->Index());
    }
}

?>