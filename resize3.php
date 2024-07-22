<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload and Resize</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Upload and Resize Image</h2>
    <form action="upload3.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Choose an image to upload:</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Image</button>
    </form>

    <?php if (isset($_GET['small']) && isset($_GET['medium']) && isset($_GET['large'])): ?>
        <div class="mt-5">
            <h4>Resized Images</h4>
            <div class="row">
                <div class="col-md-4">
                    <h5>Small (<?php echo isset($_GET['small_size']) ? $_GET['small_size'] : 'Unknown'; ?> KB)</h5>
                    <img src="<?php echo $_GET['small']; ?>" class="img-fluid" alt="Small Image">
                    <a href="<?php echo $_GET['small']; ?>" class="btn btn-secondary mt-2" download>Download Small</a>
                </div>
                <div class="col-md-4">
                    <h5>Medium (<?php echo isset($_GET['medium_size']) ? $_GET['medium_size'] : 'Unknown'; ?> KB)</h5>
                    <img src="<?php echo $_GET['medium']; ?>" class="img-fluid" alt="Medium Image">
                    <a href="<?php echo $_GET['medium']; ?>" class="btn btn-secondary mt-2" download>Download Medium</a>
                </div>
                <div class="col-md-4">
                    <h5>Large (<?php echo isset($_GET['large_size']) ? $_GET['large_size'] : 'Unknown'; ?> KB)</h5>
                    <img src="<?php echo $_GET['large']; ?>" class="img-fluid" alt="Large Image">
                    <a href="<?php echo $_GET['large']; ?>" class="btn btn-secondary mt-2" download>Download Large</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
