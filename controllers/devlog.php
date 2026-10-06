<?php

class DevLog extends Controller
{
    protected function index()
    {
        $viewmodel = new DevlogModel();
        $labelmodel = new LabelsModel();
        $index = $viewmodel->Index();
        if(is_null($index))
        {
            $this->returnToPage("projects");
            return;
        }
        $datas = array("viewModel"          => $index,
                       "returnprjlbl"       => $labelmodel->getLabelByRef('returnprjlink'),
                       "datecreationlbl"    => $labelmodel->getLabelByRef('datecreation')
                    );
        $this->returnView($datas);
    }
}

?>