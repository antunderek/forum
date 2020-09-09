<?php

namespace classes;

class ImageUpload {
    public function upload() {
        $targetFile = IMAGE_PATH . basename($_FILES["image"]["name"]);
        $valid = true;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (isset($_POST['submit'])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $valid = true;
            }
        } else {
            echo "File is not an image.";
            $valid = false;
        }
    }
}