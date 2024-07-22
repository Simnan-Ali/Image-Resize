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
    $imageName = $_FILES['image']['name'];
    $destinationPath = $uploadDir . $imageName;

    try {
        move_uploaded_file($imageTmpPath, $destinationPath);

        $sizes = [
            'small' => ['width' => 150, 'height' => 100],
            'medium' => ['width' => 300, 'height' => 200],
            'large' => ['width' => 800, 'height' => 600]
        ];

        $resizedPaths = [];
        $resizedSizes = [];
        foreach ($sizes as $size => $dimensions) {
            $resizedDestinationPath = $uploadDir . $size . '_' . $imageName;
            resizeImage($destinationPath, $resizedDestinationPath, $dimensions['width'], $dimensions['height']);
            $resizedPaths[$size] = $resizedDestinationPath;
            $resizedSizes[$size] = round(filesize($resizedDestinationPath) / 1024, 2); // File size in KB
        }

        header('Location: resize3.php?small=' . urlencode($resizedPaths['small']) . '&medium=' . urlencode($resizedPaths['medium']) . '&large=' . urlencode($resizedPaths['large']) .
            '&small_size=' . urlencode($resizedSizes['small']) . '&medium_size=' . urlencode($resizedSizes['medium']) . '&large_size=' . urlencode($resizedSizes['large']));
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No image uploaded.";
}
?>
