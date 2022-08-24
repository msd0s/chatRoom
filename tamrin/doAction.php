<?php
session_start();
include_once 'config.php';

if ($connectType=='json') {
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

        $redirectPath=$rootPath.'login.php';

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

        $redirectPath=$rootPath."index.php";
        $redirectBack=$rootPath."login.php?errMsg=Username Or Password is Wrong!";

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

        $redirectPath=$rootPath.'login.php';

        $target_dir = "./uploads/";
        $finalUploadPath=$rootPath.'uploads/'.$_FILES["uploadFile"]["name"];

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
}
elseif ($connectType=='mysql')
{
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

        $redirectPath=$rootPath.'login.php';

        /************* check that username exist or not *************/
        $checkExistQuery = 'select * from users where username = :username && password = :password';
        $check = $con->prepare($checkExistQuery);
        $check->execute(['username' => $username,'password' => $password]);
        $getUserCount = $check->rowCount();
        /********** if user do not exist register it ***********/
        if ($getUserCount==0)
        {
            $query = 'insert into users (fname,lname,email,username,password) values (:fname,:lname,:email,:username,:password)';
            $register = $con->prepare($query);
            $register->execute(['fname'=>$fname,'lname'=>$lname,'email'=>$email,'username'=>$username,'password'=>$password]);
            $userExists=1;
        }

        header("Location: $redirectPath");
    }
    /************************** Login Codes *************************/
    if (isset($_POST['loginBtn']))
    {
        $username=$_POST['username'];
        $password=$_POST['password'];
        $userExists=0;

        $redirectPath=$rootPath."index.php";
        $redirectBack=$rootPath."login.php?errMsg=Username Or Password is Wrong!";

        /************* check that username exist or not *************/
        $checkExistQuery = 'select * from users where username = :username && password = :password';
        $check = $con->prepare($checkExistQuery);
        $check->execute(['username' => $username,'password' => $password]);
        $getUserData = $check->fetch();
        $getUserCount = $check->rowCount();
        /************** if username and password is correct redirect to chat page *************/
        if ($getUserCount>0)
        {
            $userExists=1;
            $_SESSION['userid']=$getUserData["id"];
            $_SESSION['username']=$getUserData["username"];
            $_SESSION['name']=$getUserData["fname"].' '.$getUserData["lname"];
            $_SESSION['email']=$getUserData["email"];
            $_SESSION['privilege']=$getUserData["privilege"];
            header("Location: $redirectPath");
        }

        /************** if username and password is wrong redirect to login page *************/
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
            $query = 'insert into chats (textmassage,user_id) values (:textmassage,:user_id)';
            $register = $con->prepare($query);
            $register->execute(['textmassage'=>$textMassage,'user_id'=>$_SESSION['userid']]);
        }
        return true;
    }

    /************************** Delete chat from chats.json *************************/
    if (isset($_POST['deleteid']))
    {
        $id=$_POST['deleteid'];

        $checkExistQuery = 'select * from chats where id = :chatid';
        $check = $con->prepare($checkExistQuery);
        $check->execute(['chatid' => $id]);
        $getChatData = $check->fetch(PDO::FETCH_ASSOC);
        $getChatCount = $check->rowCount();

        if ($_SESSION['privilege']==1 || ($getChatCount>0 && $getChatData['user_id']==$_SESSION['userid'])) {
            $query = 'DELETE FROM chats where id = :chatid';
            $register = $con->prepare($query);
            $register->execute(['chatid'=>$id]);
        }

        return true;
    }

    /************************** upload files and save address in chats.json *************************/
    if(isset($_FILES["uploadFile"])) {

        $redirectPath=$rootPath.'login.php';

        $target_dir = "./uploads/";
        $finalUploadPath=$rootPath.'uploads/'.$_FILES["uploadFile"]["name"];

        $target_file = $target_dir .$_FILES["uploadFile"]["name"];
        if (file_exists($target_file))
        {
            $target_file = $target_dir .time().$_FILES["uploadFile"]["name"];
        }else
        {
            move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file);
        }

        $query = 'insert into chats (fileurl,user_id) values (:fileurl,:user_id)';
        $register = $con->prepare($query);
        $register->execute(['fileurl'=>$finalUploadPath,'user_id'=>$_SESSION['userid']]);

        return true;
    }


    /************************** Change Massages text and Save To chats.json *************************/
    if (isset($_POST['newmassage']))
    {
        $arrayKey=$_POST['arraykey'];
        $username=$_POST['username'];
        $textMassage=$_POST['newmassage'];

        /************* check that username exist or not *************/
        $checkExistQuery = 'select * from chats where id = :chatid';
        $check = $con->prepare($checkExistQuery);
        $check->execute(['chatid' => $arrayKey]);
        $getChatData = $check->fetch(PDO::FETCH_ASSOC);
        $getChatCount = $check->rowCount();
        /************** if username and password is correct redirect to chat page *************/

        if ($_SESSION['privilege']==1 || ($getChatCount>0 && $getChatData['user_id']==$_SESSION['userid'])) {
            if (strlen($textMassage) < 100) {
                $query = 'UPDATE chats SET textmassage = :textmassage where id = :chatid';
                $register = $con->prepare($query);
                $register->execute(['textmassage' => $textMassage, 'chatid' => $arrayKey]);
            }
        }
        return true;
    }
    if (isset($_GET['getAllChats']))
    {
        $getAllChatsQuery = 'select * from chats';
        $check = $con->prepare($getAllChatsQuery);
        $check->execute();
        $getAllChats = $check->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($getAllChats);
    }
}