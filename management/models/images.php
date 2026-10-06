<?php
class File {
    public $name;
    public $directory;
    
    public static function sort($f1, $f2)
    {
        $dircmp = strcmp($f1->directory, $f2->directory);
        if ($dircmp == 0)
            return strcmp($f1->name, $f2->name);
        return $dircmp;
    }
}

class ImagesModel extends Model
{
    private $returnPage = "images";
    private $imagesDir = "assets/images/";

    public function Index()
    {
        $arrFiles = array();
        $imgdir = $this->GetImageDirectories();
        foreach ($imgdir as $dir)
        {
            $arrPngFiles = glob($dir . "/*.{jpg,png,bmp,gif,pdf}", GLOB_BRACE);
            foreach ($arrPngFiles as $PngFile)
            {
                $PngFileName = basename($PngFile);
    
                $file = new File();
                $file->name = $PngFileName;
                $file->directory = basename($dir);
                array_push($arrFiles, $file);
                uasort($arrFiles, 'File::sort');
            }
        }
        return $arrFiles;
    }

    public function Add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_ENCODED);
        if (isset($post['submit']))
        {
            try
            {
                // Undefined | Multiple Files | $_FILES Corruption Attack
                // If this request falls under any of them, treat it invalid.
                if (!isset($_FILES['upfile']['error']) ||
                    is_array($_FILES['upfile']['error']))
                {
                    throw new RuntimeException('Invalid parameters.');
                }
                
                // Check $_FILES['upfile']['error'] value.
                switch ($_FILES['upfile']['error'])
                {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new RuntimeException('No file sent.');
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new RuntimeException('Exceeded filesize limit.');
                    default:
                        throw new RuntimeException('Unknown errors.');
                }
                
                // You should also check filesize here.
                if ($_FILES['upfile']['size'] > 5000000) {
                    throw new RuntimeException('Exceeded filesize limit.');
                }
                
                // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
                // Check MIME Type by yourself.
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                if (false === $ext = array_search($finfo->file($_FILES['upfile']['tmp_name']),
                                                  array('jpg' => 'image/jpeg',
                                                        'png' => 'image/png',
                                                        'gif' => 'image/gif',
                                                        'pdf' => 'application/pdf'),
                                                  true))
                {
                    throw new RuntimeException('Invalid file format.');
                }
                
                // You should name it uniquely.
                // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                // On this example, obtain safe unique name from its binary data.
                $file = basename($_FILES['upfile']['name']);
                if (!move_uploaded_file($_FILES['upfile']['tmp_name'], sprintf('%s%s/%s/%s',ROOT_DIR, $this->imagesDir, $post['directory'], $file)))
                {
                    throw new RuntimeException('Failed to move uploaded file.');
                }
                
                Messages::setMsg("Chargement du fichier '".$file."' réussi.", 'success');
                $this->returnToPage($this->returnPage);
            }
            catch (RuntimeException $e)
            {
                    Messages::setMsg($e->getMessage(), 'error');
            }
        }
        return;
    }
    
    public function GetImageDirectories()
    {
        return glob(ROOT_DIR. $this->imagesDir . "*", GLOB_ONLYDIR);
    }

}
?>