<?php

class Labels extends Controller
{
  protected function add()
  {
      $this->checkLogin();
      $viewmodel = new LabelsModel();
      $this->returnView($viewmodel->Add());
  }

  protected function update()
  {
      $this->checkLogin();
      $this->checkId();
      $viewmodel = new LabelsModel();
      $this->returnView($viewmodel->Update());
  }

  protected function delete()
  {
      $this->checkLogin();
      $this->checkId();
      $viewmodel = new LabelsModel();
      $this->returnView($viewmodel->Delete());
  }
}

?>