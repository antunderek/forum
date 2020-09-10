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

        if ($valid === false) {
            echo "file was not uploaded";
            return;
        }
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        }
    }

    public function checkFileSize() {
        if ($_FILES["image"]["size"] > 2000000) {
            return false;
        }
        return true;
    }

    public function checkFormat($imageFileType) {
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            return false;
        }
        return true;
    }
}