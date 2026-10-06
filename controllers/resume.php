<?php

class Resume extends Controller
{
    protected function index()
    {
        $labelModel = new LabelsModel();
        $this->returnView(
            array(
                "viewModelTitles"       =>  (new ResumeModel())->Index(),
                "viewModelExperience"   =>  (new ExperiencesModel())->Index(),
                "viewModelEducation"    =>  (new EducationModel())->Index(),
                "profile"               =>  (new ProfileModel())->Index(),
                "links"                 =>  (new LinksModel())->Index(),
                "skills"                =>  (new SkillsModel())->Index(),
                "lbl_links"             =>  $labelModel->getLabelByRef('resumelinks'),
                "lbl_skills"            =>  $labelModel->getLabelByRef('resumeskills'),
                "identity"              =>  (new IdentityModel())->Index(),
            )
        );
    }
}

?>