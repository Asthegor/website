<?php

class Resume extends Controller
{
    protected function index()
    {
        $viewmodelexp = new ExperiencesModel();
        $dataExp = $viewmodelexp->Index();
        $viewmodeledu = new EducationModel();
        $dataEdu = $viewmodeledu->Index();
        $viewmodelresume = new ResumeModel();
        $titles = $viewmodelresume->Index();
        $this->returnView(array("viewModelTitles"=>$titles,"viewModelExperience"=>$dataExp,"viewModelEducation"=>$dataEdu));
    }
}

?>