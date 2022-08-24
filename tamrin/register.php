<?php
include_once 'config.php';
?>
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
            <h3 class="w-100 text-center mt-2">Register Page</h3>
            <form class="my-4" id="registerForm" action="./doAction.php" method="post">
                <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" name="fname" class="form-control" id="fname" placeholder="Enter First Name" required>
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" name="lname" class="form-control" id="lname" placeholder="Enter Last Name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter Your Email" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="registerusername" class="form-control" id="registerusername" placeholder="Enter Username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
                </div>
                <button type="submit" name="registerBtn" id="registerBtn" class="btn btn-success">Register</button>
            </form>
        </div>
    </div>
</div>
<script>
    var btn= document.querySelector('#registerBtn').addEventListener('click',function (e) {
        e.preventDefault();
        var mail_format = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
        var username_format = /^[a-zA-Z0-9_]+$/;
        var fname_format = /^[a-z]+$/;
        var lname_format = /^[a-z]+$/;
        var validcheck=0;

        if(document.getElementById('email').value.match(mail_format))
        {
            if(document.getElementById('registerusername').value.length>3 && document.getElementById('registerusername').value.length<32 && document.getElementById('registerusername').value.match(username_format))
            {
                if(document.getElementById('fname').value.length>3 && document.getElementById('fname').value.length<32 && document.getElementById('fname').value.match(fname_format))
                {
                    if(document.getElementById('lname').value.length>3 && document.getElementById('lname').value.length<32 && document.getElementById('lname').value.match(lname_format))
                    {
                        if(document.getElementById('password').value.length>4 && document.getElementById('password').value.length<32)
                        {
                            validcheck=1;
                        }
                    }
                }
            }
        }
        if (validcheck===1)
        {
            document.getElementById('registerForm').submit();
        }



    });

</script>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js" ></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>