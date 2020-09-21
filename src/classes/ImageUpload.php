<?php

namespace classes;

class ImageUpload {
    public function upload() {
        $targetFile = IMAGE_FULLPATH . basename($_FILES["image"]["name"]);
        $valid = true;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (isset($_POST['submit'])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $valid = true;
            }
        } else {
            $valid = false;
        }

        if ($valid === false) {
            header('Location: /profile');
            exit;
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            return $_FILES['image']['name'];
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