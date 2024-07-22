<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Image Upload and Resize</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Upload and Resize Image</h1>
    <form action="upload2.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Choose Image</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>
        <div class="form-group">
            <label for="smallWidth">Small Size (width x height)</label>
            <div class="input-group">
                <input type="number" class="form-control" id="smallWidth" name="sizes[small][width]" placeholder="Width" required>
                <input type="number" class="form-control" id="smallHeight" name="sizes[small][height]" placeholder="Height" required>
            </div>
        </div>
        <div class="form-group">
            <label for="mediumWidth">Medium Size (width x height)</label>
            <div class="input-group">
                <input type="number" class="form-control" id="mediumWidth" name="sizes[medium][width]" placeholder="Width" required>
                <input type="number" class="form-control" id="mediumHeight" name="sizes[medium][height]" placeholder="Height" required>
            </div>
        </div>
        <div class="form-group">
            <label for="largeWidth">Large Size (width x height)</label>
            <div class="input-group">
                <input type="number" class="form-control" id="largeWidth" name="sizes[large][width]" placeholder="Width" required>
                <input type="number" class="form-control" id="largeHeight" name="sizes[large][height]" placeholder="Height" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Upload and Resize</button>
    </form>

    <?php if (isset($_GET['resized_images'])): ?>
        <?php $resizedImages = $_GET['resized_images']; ?>
        <div class="mt-5">
            <h4>Resized Images</h4>
            <div class="row">
                <?php foreach ($resizedImages as $size => $info): ?>
                    <div class="col-md-4 mb-4">
                        <h5><?php echo ucfirst($size); ?> (<?php echo $info['size']; ?> KB)</h5>
                        <img src="<?php echo htmlspecialchars($info['path']); ?>" class="img-fluid" alt="<?php echo ucfirst($size); ?> Image">
                        <a href="<?php echo htmlspecialchars($info['path']); ?>" class="btn btn-secondary mt-2" download>Download <?php echo ucfirst($size); ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>

