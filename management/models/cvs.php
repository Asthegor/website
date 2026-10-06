<?php

class CVsModel extends Model
{
    private $returnPage = 'cvs';
    private $targetDir = 'files/';
    
    public function Index()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['submit']))
        {
            $fileid = "cvfr";
            if (isset($_FILES[$fileid]))
            {
                $file = basename($_FILES[$fileid]["name"]);
                $fileExtension = strtolower(pathinfo($file,PATHINFO_EXTENSION));
                if($fileExtension != "" && $fileExtension !== "docx")
                {
                    Messages::setMsg("Error : file '".$file."' must have the extension 'docx'.", 'error');
                }
                else
                {
                    $target_file = ROOT_DIR.$this->targetDir.'LACOMBE_Dominique_CV_FR.docx';
                    $upload = move_uploaded_file($_FILES[$fileid]["tmp_name"], $target_file);
                }
            }
            $fileid = "cven";
            if (isset($_FILES[$fileid]))
            {
                $file = basename($_FILES[$fileid]["name"]);
                $fileExtension = strtolower(pathinfo($file,PATHINFO_EXTENSION));
                if($fileExtension != "" && $fileExtension !== "docx")
                {
                    Messages::setMsg("Error : file '".$file."' must have the extension 'docx'.", 'error');
                }
                else
                {
                    $target_file = ROOT_DIR.$this->targetDir.'LACOMBE_Dominique_CV_EN.docx';
                    $upload = move_uploaded_file($_FILES[$fileid]["tmp_name"], $target_file);
                }
            }
        }
    }

}
?>