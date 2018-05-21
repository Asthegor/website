<?php
class Frameworks extends Controller
{
    protected function index()
    {
        $this->checkLogin();
        $viewmodel = new FrameworksModel();
        $this->returnView($viewmodel->Index());
    }

    protected function add()
    {
        $this->checkLogin();
        $viewmodel = new FrameworksModel();
        $this->returnView($viewmodel->Add());
    }

    protected function update()
    {
        $this->checkLogin();
        if ($_GET['id'] == '')
        {
            header('Location: '.ROOT_MNGT.'/'.strtolower(get_class($this)));
        }
        $viewmodel = new FrameworksModel();
        $this->returnView($viewmodel->Update());
    }

    protected function delete()
    {
        $this->checkLogin();
        if ($_GET['id'] == '')
        {
            header('Location: '.ROOT_MNGT.'/'.strtolower(get_class($this)));
        }
        $viewmodel = new FrameworksModel();
        $this->returnView($viewmodel->Delete());
    }
}
?>