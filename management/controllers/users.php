<?php

class Users extends Controller
{
    protected function login()
    {
        if (isset($_SESSION['is_logged_in']))
        {
            header('Location: '.ROOT_MNGT.'home');
        }
        $viewmodel = new UsersModel();
        $this->returnView($viewmodel->Login(), false);
    }

    protected function logout()
    {
        unset($_SESSION['is_logged_in']);
        unset($_SESSION['user_data']);
        session_destroy();
        // Redirect
        header('Location: '.ROOT_URL);
    }
}

?>