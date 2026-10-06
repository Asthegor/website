<?php

class Profile extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new ProfileModel();
        $this->returnView($viewmodel->Index());
    }

}

?>