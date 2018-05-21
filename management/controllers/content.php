<?php

class Content extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new ContentModel();
        $this->returnView($viewmodel->Index());
    }

    protected function add()
    {
        $this->checkLogin();
        $viewmodel = new ContentModel();
        $this->returnView($viewmodel->Add());
    }

    protected function update()
    {
        $this->checkLogin();
        if ($_GET['id'] == '')
        {
            header('Location: '.ROOT_MNGT.'/'.strtolower(get_class($this)));
        }
        $viewmodel = new contentModel();
        $this->returnView($viewmodel->Update());
    }

    protected function delete()
    {
        $this->checkLogin();
        $viewmodel = new ContentModel();
        $this->returnView($viewmodel->Delete());
    }
}

?>