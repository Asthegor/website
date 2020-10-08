<?php

class ImagesModel extends Model
{
    public function getImage($id)
    {
        $this->query("SELECT name, img_size, img_type, img_blob
                      FROM images
                      WHERE id = :id");
        $this->bind(':id', $id, PDO::PARAM_INT);
        $rows = $this->single();
        $this->close();
        return $rows;
    }
}

?>