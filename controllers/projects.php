<?php

class Projects extends Controller
{
    protected function index()
    {
        $viewmodel = new ProjectsModel();
        $labelmodel = new LabelsModel();
        $frameworks = new FrameworksModel();
        $datas = array("viewModel"          => $viewmodel->Index(),
                       "projectviews"       => $labelmodel->getLabelByRef('projectviews'),
                       "projectuniqueviews" => $labelmodel->getLabelByRef('projectuniqueviews'),
                       "frameworks"         => $frameworks->getAllFrameworks(),
                       "frameworklbl"       => $labelmodel->getLabelByRef('framework'),
                       "nbprojectslbl"      => $labelmodel->getLabelByRef('nbprojects'),
                       "alllbl"             => $labelmodel->getLabelByRef('all')
                      );
        $this->returnView($datas);
    }
}

?>