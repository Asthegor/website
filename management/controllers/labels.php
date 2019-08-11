<?php

class Labels extends Controller
{
  protected function add()
  {
      $this->checkLogin();
      $viewmodel = new LabelModel();
      $this->returnView($viewmodel->Add());
  }

  protected function update()
  {
      $this->checkLogin();
      $this->checkId();
      $viewmodel = new LabelModel();
      $this->returnView($viewmodel->Update());
  }

  protected function delete()
  {
      $this->checkLogin();
      $this->checkId();
      $viewmodel = new LabelModel();
      $this->returnView($viewmodel->Delete());
  }
}

?>