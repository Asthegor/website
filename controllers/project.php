<?php

class Project extends Controller
{
    protected function index()
    {
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        
        $viewmodel = new ProjectModel();
        $slugValid = $viewmodel->IsSlugValid($get['action']);
        if (!$slugValid)
        {
            $this->returnToPage("projects");
            return;
        }

        $labelmodel = new LabelsModel();
        $viewdevlog = new DevlogModel();
        $datas = array("viewModel"          => $viewmodel->Index(),
                       "frameworkenginelbl" => $labelmodel->getLabelByRef('frameworkengine'),
                       "actualversionlbl"   => $labelmodel->getLabelByRef('actualversion'),
                       "initprojectlbl"     => $labelmodel->getLabelByRef('initproject'),
                       "websitelbl"         => $labelmodel->getLabelByRef('website'),
                       "downloadlinklbl"    => $labelmodel->getLabelByRef('downloadlink'),
                       "returnprjlbl"       => $labelmodel->getLabelByRef('returnprjlink'),
                       "viewDevlog"         => $viewdevlog->getAllDevlog(),
                       "projectdurationlbl" => $labelmodel->getLabelByRef('projectduration'),
                    );
        $this->returnView($datas);
    }
}

?>