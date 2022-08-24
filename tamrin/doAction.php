<?php
session_start();


/************************** Register Codes *************************/
if (isset($_POST['registerusername']))
{
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $username=$_POST['registerusername'];
    $password=$_POST['password'];
    $privilege=2;
    $userExists=0;
    /*if (!file_exists('./'.$username))
    {
        mkdir('./'.$username);
    }*/

    $projectDirectory=explode('/',$_SERVER['PHP_SELF']);
    $redirectPath=$_SERVER['HTTP_ORIGIN'].'/'.$projectDirectory[1].'/login.php';

    $filename = 'users.json';
    $data = file_get_contents($filename); //data read from json file
    // print_r($data);
    $users = json_decode($data,true);  //decode a data
    foreach ($users as $user) {
        if ($username == $user["username"] && $password == $user["password"]) {
            $userExists=1;
            break;
        }
    }

    if ($userExists==0)
    {
        $userData=[
            'fname'=>$fname,
            'lname'=>$lname,
            'email'=>$email,
            'username'=>$username,
            'password'=>$password,
            'privilege'=>$privilege,
        ];
        $users[]=$userData;
        file_put_contents($filename,json_encode($users));
    }
    header("Location: $redirectPath");
}
/************************** Login Codes *************************/
if (isset($_POST['loginBtn']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $userExists=0;

    $projectDirectory=explode('/',$_SERVER['PHP_SELF']);
    $redirectPath=$_SERVER['HTTP_ORIGIN'].'/'.$projectDirectory[1]."/index.php";
    $redirectBack=$_SERVER['HTTP_ORIGIN'].'/'.$projectDirectory[1]."/login.php?errMsg=Username Or Password is Wrong!";

    $filename = 'users.json';
    $data = file_get_contents($filename); //data read from json file
    $users = json_decode($data,true);  //decode a data

    foreach ($users as $user) {
        if ($username == $user["username"] && $password == $user["password"]) {
            $userExists=1;
            $_SESSION['username']=$user["username"];
            $_SESSION['name']=$user["fname"].' '.$user["lname"];
            $_SESSION['email']=$user["email"];
            $_SESSION['privilege']=$user["privilege"];
            header("Location: $redirectPath");
        }
    }

    if ($userExists==0)
    {
        header("Location: $redirectBack");
    }
}

/************************** Save Massages To chats.json *************************/
if (isset($_POST['textmassage']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $privilege=$_POST['privilege'];
    $textMassage=$_POST['textmassage'];

    if (strlen($textMassage)<100)
    {
        $filename = 'chats.json';
        $data = file_get_contents($filename); //data read from json file

        $chats = json_decode($data,true);
        if (count($chats)==0)
        {
            $x=1;
        }else
        {
            $lastChatArray=end($chats);
            $x=$lastChatArray['id']+1;
        }
        $userData=[
            'id'=>$x,
            'name'=>$name,
            'email'=>$email,
            'username'=>$username,
            'privilege'=>$privilege,
            'textmassage'=>$textMassage,
            'fileurl'=>'',
        ];
        $chats[]=$userData;
        file_put_contents($filename,json_encode($chats));
    }
    return true;
}

/************************** Delete chat from chats.json *************************/
if (isset($_POST['deleteid']))
{
    $id=$_POST['deleteid'];

    $filename = 'chats.json';
    $data = file_get_contents($filename); //data read from json file

    $chats = json_decode($data,true);
    if ($_SESSION['privilege']==1 || $chats[$id]['username']==$_SESSION['username']) {
        unset($chats[$id]);
    }
    //$finalChats=array_values($chats);
    //$chats[]=$userData;
    file_put_contents($filename,json_encode($chats));
    return true;
}

/************************** upload files and save address in chats.json *************************/
if(isset($_FILES["uploadFile"])) {

    $projectDirectory=explode('/',$_SERVER['PHP_SELF']);
    $redirectPath=$_SERVER['HTTP_ORIGIN'].'/'.$projectDirectory[1].'/login.php';

    $target_dir = "./uploads/";
    $finalUploadPath=$_SERVER['HTTP_ORIGIN'].'/'.$projectDirectory[1].'/uploads/'.$_FILES["uploadFile"]["name"];

    $target_file = $target_dir .$_FILES["uploadFile"]["name"];
    if (file_exists($target_file))
    {
        $target_file = $target_dir .time().$_FILES["uploadFile"]["name"];
    }else
    {
        move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file);
    }

    $name=$_SESSION['name'];
    $email=$_SESSION['email'];
    $username=$_SESSION['username'];
    $privilege=$_SESSION['privilege'];
    $textMassage='';

    $filename = 'chats.json';
    $data = file_get_contents($filename); //data read from json file

    $chats = json_decode($data,true);
    if (count($chats)==0)
    {
        $x=1;
    }else
    {
        $lastChatArray=end($chats);
        $x=$lastChatArray['id']+1;
    }
    $userData=[
        'id'=>$x,
        'name'=>$name,
        'email'=>$email,
        'username'=>$username,
        'privilege'=>$privilege,
        'textmassage'=>$textMassage,
        'fileurl'=>$finalUploadPath,
    ];
    $chats[]=$userData;
    file_put_contents($filename,json_encode($chats));
    return true;
}


/************************** Change Massages text and Save To chats.json *************************/
if (isset($_POST['newmassage']))
{
    $arrayKey=$_POST['arraykey'];
    $username=$_POST['username'];
    $textMassage=$_POST['newmassage'];

    $filename = 'chats.json';
    $data = file_get_contents($filename); //data read from json file
    $chats = json_decode($data,true);

    if ($_SESSION['privilege']==1 || $chats[$arrayKey]['username']==$_SESSION['username'])
    {
        if (strlen($textMassage)<100)
        {
            $chats[$arrayKey]['textmassage']=$textMassage;
        }
    }
    file_put_contents($filename,json_encode($chats));
    return true;
}