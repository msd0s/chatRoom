<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>Register User</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-4 mx-auto my-4 border shadow p-3 mb-5 bg-body rounded">
            <h3 class="w-100 text-center mt-2">Login Page</h3>
            <?php
                if (isset($_GET['errMsg']))
                {
            ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_GET['errMsg']; ?>
                    </div>
            <?php
                }
            ?>
            <form class="my-4" action="doAction.php" method="post">
                <input type="hidden" name="redirectPath" value="<?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]; ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                </div>
                <button type="submit" name="loginBtn" class="btn btn-primary">Login</button>
                <a href="<?php echo 'http://'.$_SERVER["HTTP_HOST"].'/tamrin/register.php'; ?>" class="btn btn-primary">Register Form</a>
            </form>
        </div>
    </div>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js" ></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>