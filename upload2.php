<?php
function resizeImage($sourcePath, $destinationPath, $newWidth, $newHeight)
{
    $imageInfo = getimagesize($sourcePath);
    $mimeType = $imageInfo['mime'];

    switch ($mimeType) {
        case 'image/jpeg':
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case 'image/gif':
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        default:
            throw new Exception('Unsupported image type');
    }

    list($originalWidth, $originalHeight) = getimagesize($sourcePath);
    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

    if ($mimeType == 'image/png' || $mimeType == 'image/gif') {
        imagecolortransparent($resizedImage, imagecolorallocatealpha($resizedImage, 0, 0, 0, 127));
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
    }

    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

    switch ($mimeType) {
        case 'image/jpeg':
            imagejpeg($resizedImage, $destinationPath);
            break;
        case 'image/png':
            imagepng($resizedImage, $destinationPath);
            break;
        case 'image/gif':
            imagegif($resizedImage, $destinationPath);
            break;
    }

    imagedestroy($sourceImage);
    imagedestroy($resizedImage);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $imageTmpPath = $_FILES['image']['tmp_name'];
    $imageName = basename($_FILES['image']['name']);
    $destinationPath = $uploadDir . $imageName;

    try {
        move_uploaded_file($imageTmpPath, $destinationPath);

        $sizes = $_POST['sizes']; // Array of sizes from the form

        $resizedPaths = [];
        foreach ($sizes as $key => $dimensions) {
            $width = $dimensions['width'];
            $height = $dimensions['height'];
            $resizedDestinationPath = $uploadDir . $key . '_' . $imageName;
            resizeImage($destinationPath, $resizedDestinationPath, $width, $height);
            $resizedSize = round(filesize($resizedDestinationPath) / 1024, 2); // File size in KB
            $resizedPaths[$key] = [
                'path' => $resizedDestinationPath,
                'size' => $resizedSize
            ];
        }

        // Pass resized image paths to index.php
        header('Location: resize2.php?' . http_build_query([
            'resized_images' => $resizedPaths
        ]));
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
