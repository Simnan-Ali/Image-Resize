<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload and Resize</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Upload and Resize Image</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Choose Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <div class="form-group col-lg-6">
                <label for="width">Width</label>
                <input type="number" class="form-control" id="width" name="width" required>
            </div>
            <div class="form-group col-lg-6">
                <label for="height">Height</label>
                <input type="number" class="form-control" id="height" name="height" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload and Resize</button>
        </form>

        <?php if (isset($_GET['resized_path'])): ?>
            <h2 class="my-4">Resized Image</h2>
            <div class="card">
                <img src="<?php echo htmlspecialchars($_GET['resized_path']); ?>" class="card-img-top" alt="Resized Image">
                <div class="card-body">
                    <h5 class="card-title">Image Size: <?php echo htmlspecialchars($_GET['resized_size']); ?> KB</h5>
                    <a href="<?php echo htmlspecialchars($_GET['resized_path']); ?>" class="btn btn-primary" download>Download Resized Image</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>