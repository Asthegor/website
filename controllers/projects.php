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
                       "frameworklbl"       => $labelmodel->getLabelByRef('framework')
                    );
        $this->returnView($datas);
    }
}

?>