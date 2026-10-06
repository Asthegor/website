<?php

class Projects extends Controller
{
    protected function index()
    {
        $viewmodel = new ProjectsModel();
        $labelmodel = new LabelsModel();
        $frameworks = new FrameworksModel();
        $datas = array("projects"               => $viewmodel->Index(),
                       "projectviews"           => $labelmodel->getLabelByRef('projectviews'),
                       "projectuniqueviews"     => $labelmodel->getLabelByRef('projectuniqueviews'),
                       "frameworks"             => $frameworks->getAllFrameworks(),
                       "frameworklbl"           => $labelmodel->getLabelByRef('framework'),
                       "nbprojectslbl"          => $labelmodel->getLabelByRef('nbprojects'),
                       "projectlistzone1lbl"    => $labelmodel->getLabelByRef('projectlistzone1'),
                       "projectlistzone2lbl"    => $labelmodel->getLabelByRef('projectlistzone2'),
                       "projectlistzone3lbl"    => $labelmodel->getLabelByRef('projectlistzone3'),
                       "projectlistzone1id"     => $labelmodel->getLabelIdByRef('projectlistzone1'),
                       "projectlistzone2id"     => $labelmodel->getLabelIdByRef('projectlistzone2'),
                       "projectlistzone3id"     => $labelmodel->getLabelIdByRef('projectlistzone3'),
                       "projectlistlinklbl"     => $labelmodel->getLabelByRef('projectlistlink')
                    );
        $this->returnView($datas);
    }
}

?>