<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/chat.css">
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <title>Document</title>
</head>
<body>
<!-- component -->
<div class="flex-1 p:2 sm:p-6 justify-between flex flex-col h-screen">
    <div class="flex sm:items-center justify-between py-3 border-b-2 border-gray-200">
        <div class="relative flex items-center space-x-4">
            <div class="relative">
            <span class="absolute text-green-500 right-0 bottom-0">
               <svg width="20" height="20">
                  <circle cx="8" cy="8" r="8" fill="currentColor"></circle>
               </svg>
            </span>
                <img src="<?php echo $rootPath ?>img/avatar.jpg" alt="" class="w-10 sm:w-16 h-10 sm:h-16 rounded-full">
            </div>
            <div class="flex flex-col leading-tight">
                <div class="text-2xl mt-1 flex items-center">
                    <span class="text-gray-700 mr-3"><?php echo $_SESSION['name']; ?></span>
                </div>
                <span class="text-lg text-gray-600"><?php echo $_SESSION['email']; ?></span>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <button type="button" class="inline-flex items-center justify-center rounded-lg border h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
            <button type="button" class="inline-flex items-center justify-center rounded-lg border h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
            <a href="?logout" class="inline-flex items-center justify-center rounded-lg border h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-power h-6 w-6" viewBox="0 0 16 16">
                    <path d="M7.5 1v7h1V1h-1z"/>
                    <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
                </svg>
            </a>
        </div>
    </div>
    <div id="messages" class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
        <?php
        $filename = 'chats.json';
        $data = file_get_contents($filename); //data read from json file
        $allChats = json_decode($data,true);  //decode a data

        $selectAllChatsQuery = 'select * from chats';
        $runQuery = $con->prepare($selectAllChatsQuery);
        $runQuery->execute();
        $allChats = $runQuery->fetchAll();

        if (isset($allChats)){
            foreach ($allChats as $key => $chat) {
                if ($chat["user_id"] == $_SESSION['userid']) {
                    if ($chat['textmassage']!='' && $chat['fileurl']=='')
                    {
                        ?>
                        <div class="chat-message">
                            <div class="flex items-end justify-end">
                                <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                                    <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white "><?php echo $chat['textmassage']; ?></span></div>
                                </div>
                                <img src="<?php echo $rootPath ?>img/avatar.jpg" alt="My profile" class="w-6 h-6 rounded-full order-2">
                                <div class="flex">
                                    <button type="button" class="editMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="<?php echo $chat['user_id']; ?>" data-id="<?php echo $chat['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil-square h-6 w-6 text-gray-600" viewBox="0 0 18 18">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="deleteMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="<?php echo $chat['user_id']; ?>" data-id="<?php echo $chat['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash-fill h-6 w-6 text-gray-600" viewBox="0 0 18 18">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }else
                    {
                        ?>
                        <div class="chat-message">
                            <div class="flex items-end justify-end">
                                <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                                    <div><img src="<?php echo $chat['fileurl']; ?>" class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white "></div>
                                </div>
                                <img src="<?php echo $rootPath ?>img/avatar.jpg" alt="My profile" class="w-6 h-6 rounded-full order-2">
                                <div class="flex">
                                    <button type="button" class="editMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="<?php echo $chat['user_id']; ?>" data-id="<?php echo $chat['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil-square h-6 w-6 text-gray-600" viewBox="0 0 18 18">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="deleteMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="<?php echo $chat['user_id']; ?>" data-id="<?php echo $chat['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash-fill h-6 w-6 text-gray-600" viewBox="0 0 18 18">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }else
                {
                    if ($chat['textmassage']!='' && $chat['fileurl']=='') {
                        ?>
                        <div class="chat-message">
                            <div class="flex items-end">
                                <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                    <div>
                                        <span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600"><?php echo $chat['textmassage']; ?></span>
                                    </div>
                                </div>
                                <img src="<?php echo $rootPath ?>img/avatar.jpg"
                                     alt="My profile" class="w-6 h-6 rounded-full order-1">
                                <div class="flex order-2">
                                    <button type="button"
                                            class="editMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none"
                                            data-username="<?php echo $chat['user_id']; ?>"
                                            data-id="<?php echo $chat['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                             class="bi bi-pencil-square h-6 w-6 text-gray-600" viewBox="0 0 18 18">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button"
                                            class="deleteMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none"
                                            data-username="<?php echo $chat['user_id']; ?>"
                                            data-id="<?php echo $chat['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                             class="bi bi-trash-fill h-6 w-6 text-gray-600" viewBox="0 0 18 18">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }else
                    {
                        ?>
                        <div class="chat-message">
                            <div class="flex items-end">
                                <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                    <div>
                                        <img src="<?php echo $chat['fileurl']; ?>" class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">
                                    </div>
                                </div>
                                <img src="<?php echo $rootPath ?>img/avatar.jpg"
                                     alt="My profile" class="w-6 h-6 rounded-full order-1">
                                <div class="flex order-2">
                                    <button type="button"
                                            class="editMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none"
                                            data-username="<?php echo $chat['user_id']; ?>"
                                            data-id="<?php echo $chat['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                             class="bi bi-pencil-square h-6 w-6 text-gray-600" viewBox="0 0 18 18">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd"
                                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </button>
                                    <button type="button"
                                            class="deleteMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none"
                                            data-username="<?php echo $chat['user_id']; ?>"
                                            data-id="<?php echo $chat['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                             class="bi bi-trash-fill h-6 w-6 text-gray-600" viewBox="0 0 18 18">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        }
        ?>

    </div>
    <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
        <div class="relative flex">
         <span class="absolute inset-y-0 flex items-center">
            <button type="button" class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
               </svg>
            </button>
         </span>

            <input type="hidden" id="rootPath" value="<?php echo $rootPath; ?>">
            <input type="hidden" id="fullUserData" data-userid="<?php echo $_SESSION['userid'] ?>" data-username="<?php echo $_SESSION['username'] ?>" data-privilege="<?php echo $_SESSION['privilege'] ?>" data-fullname="<?php echo $_SESSION['name'] ?>" data-email="<?php echo $_SESSION['email'] ?>">
            <input type="text" placeholder="Write your message!" id="textMassage" data-username="<?php echo $_SESSION['username'] ?>" class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-12 bg-gray-200 rounded-md py-3" maxlength="100">
            <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
                <button id="imageUpload" type="button" class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                </button>
                <input type="file" id="fileToUpload">
                <!--<button type="button" class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
                <button type="button" class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </button>-->
                <button type="button" id="sendText" class="inline-flex items-center justify-center rounded-lg px-4 py-3 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none">
                    <span class="font-bold">Send</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 ml-2 transform rotate-90">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>





<!-- Main modal -->
<div id="changeMassageForm" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 w-full hidden overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full justify-center items-center flex" aria-modal="true" role="dialog">
    <div class="relative w-full h-full max-w-md p-4 md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" id="closeMassageForm" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Change Massage</h3>
                <div class="space-y-6">
                    <div>
                        <label for="changeMassageText" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">New Massage</label>
                        <input type="text" id="changeMassageText" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    <button type="button" id="changeMassage" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Change It!</button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .scrollbar-w-2::-webkit-scrollbar {
        width: 0.25rem;
        height: 0.25rem;
    }

    .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
        --bg-opacity: 1;
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--bg-opacity));
    }

    .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
        --bg-opacity: 1;
        background-color: #edf2f7;
        background-color: rgba(237, 242, 247, var(--bg-opacity));
    }

    .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
        border-radius: 0.25rem;
    }
</style>

<script>
    const el = document.getElementById('messages');
    el.scrollTop = el.scrollHeight;

    $(document).ready(function () {
        var rootPath=$('#rootPath').val();
        $('#imageUpload').on('click', function() {
            var file_data = $('#fileToUpload').prop('files')[0];
            var form_data = new FormData();
            form_data.append('uploadFile', file_data);

            var path=$('#rootPath').val()+"doAction.php";
            /*alert(file_data);*/
            $.ajax({
                url: path,
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(php_script_response){
                    console.log('upload Success!');
                }
            });
        });

        setInterval(function () {
            var Path=$('#rootPath').val()+"doAction.php";
            $.ajax({
                method:"GET",
                url:Path,
                cache: false,
                data:{
                    getAllChats : true ,
                },
                dataType:"json",
                success: function (data) {   // success callback function
                    var items = [];
                    $.each(data, function( key, val ) {

                        var currentUsername=$('#fullUserData').attr('data-userid');
                        if(currentUsername==val.user_id)
                        {
                            if(val.textmassage!='' && val.fileurl==null) {
                                items.push('<div class="chat-message">\n' +
                                    '                            <div class="flex items-end justify-end">\n' +
                                    '                                <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">\n' +
                                    '                                    <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white ">' + val.textmassage + '</span></div>\n' +
                                    '                                </div>\n' +
                                    '                                <img src="'+ rootPath +'/img/avatar.jpg" alt="My profile" class="w-6 h-6 rounded-full order-2">\n' +
                                    '                                <div class="flex">\n' +
                                    '                                    <button type="button" class="editMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="' + val.user_id + '" data-id="' + val.id + '">\n' +
                                    '                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil-square h-6 w-6 text-gray-600" viewBox="0 0 18 18">\n' +
                                    '                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>\n' +
                                    '                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>\n' +
                                    '                                        </svg>\n' +
                                    '                                    </button>\n' +
                                    '                                    <button type="button" class="deleteMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="' + val.user_id + '" data-id="' + val.id + '">\n' +
                                    '                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash-fill h-6 w-6 text-gray-600" viewBox="0 0 18 18">\n' +
                                    '                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>\n' +
                                    '                                        </svg>\n' +
                                    '                                    </button>\n' +
                                    '                                </div>\n' +
                                    '                            </div>\n' +
                                    '                        </div>');
                            }else
                            {
                                items.push('<div class="chat-message">\n' +
                                    '                            <div class="flex items-end justify-end">\n' +
                                    '                                <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">\n' +
                                    '                                    <div><img src="'+val.fileurl+'" class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white "></div>\n' +
                                    '                                </div>\n' +
                                    '                                <img src="'+ rootPath +'/img/avatar.jpg" alt="My profile" class="w-6 h-6 rounded-full order-2">\n' +
                                    '                                <div class="flex">\n' +
                                    '                                    <button type="button" class="editMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="' + val.user_id + '" data-id="' + val.id + '">\n' +
                                    '                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil-square h-6 w-6 text-gray-600" viewBox="0 0 18 18">\n' +
                                    '                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>\n' +
                                    '                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>\n' +
                                    '                                        </svg>\n' +
                                    '                                    </button>\n' +
                                    '                                    <button type="button" class="deleteMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="' + val.user_id + '" data-id="' + val.id + '">\n' +
                                    '                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash-fill h-6 w-6 text-gray-600" viewBox="0 0 18 18">\n' +
                                    '                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>\n' +
                                    '                                        </svg>\n' +
                                    '                                    </button>\n' +
                                    '                                </div>\n' +
                                    '                            </div>\n' +
                                    '                        </div>');
                            }
                        }else {
                            if (val.textmassage != '' && val.fileurl == null) {
                                items.push('<div class="chat-message">\n' +
                                    '                            <div class="flex items-end">\n' +
                                    '                                <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">\n' +
                                    '                                    <div>\n' +
                                    '                                        <span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">' + val.textmassage + '</span>\n' +
                                    '                                    </div>\n' +
                                    '                                </div>\n' +
                                    '                                <img src="'+ rootPath +'/img/avatar.jpg" alt="My profile" class="w-6 h-6 rounded-full order-1">\n' +
                                    '                                <div class="flex order-2">\n' +
                                    '                                    <button type="button" class="editMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="' + val.user_id + '" data-id="' + val.id + '">\n' +
                                    '                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil-square h-6 w-6 text-gray-600" viewBox="0 0 18 18">\n' +
                                    '                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>\n' +
                                    '                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>\n' +
                                    '                                        </svg>\n' +
                                    '                                    </button>\n' +
                                    '                                    <button type="button" class="deleteMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="' + val.user_id + '" data-id="' + val.id + '">\n' +
                                    '                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash-fill h-6 w-6 text-gray-600" viewBox="0 0 18 18">\n' +
                                    '                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>\n' +
                                    '                                        </svg>\n' +
                                    '                                    </button>\n' +
                                    '                                </div>\n' +
                                    '                            </div>\n' +
                                    '                        </div>');
                            }else
                            {
                                items.push('<div class="chat-message">\n' +
                                    '                            <div class="flex items-end">\n' +
                                    '                                <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">\n' +
                                    '                                    <div>\n' +
                                    '                                        <img src="'+val.fileurl+'" class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">\n' +
                                    '                                    </div>\n' +
                                    '                                </div>\n' +
                                    '                                <img src="'+ rootPath +'/img/avatar.jpg" alt="My profile" class="w-6 h-6 rounded-full order-1">\n' +
                                    '                                <div class="flex order-2">\n' +
                                    '                                    <button type="button" class="editMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="' + val.user_id + '" data-id="' + val.id + '">\n' +
                                    '                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil-square h-6 w-6 text-gray-600" viewBox="0 0 18 18">\n' +
                                    '                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>\n' +
                                    '                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>\n' +
                                    '                                        </svg>\n' +
                                    '                                    </button>\n' +
                                    '                                    <button type="button" class="deleteMassage inline-flex items-center align-middle justify-center rounded-full h-7 w-7 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none" data-username="' + val.user_id + '" data-id="' + val.id + '">\n' +
                                    '                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash-fill h-6 w-6 text-gray-600" viewBox="0 0 18 18">\n' +
                                    '                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>\n' +
                                    '                                        </svg>\n' +
                                    '                                    </button>\n' +
                                    '                                </div>\n' +
                                    '                            </div>\n' +
                                    '                        </div>');
                            }
                        }

                    });

                    $('#messages').html('');
                    $.each(items, function (key,massageList) {
                        $('#messages').append(massageList);
                    });
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback
                    console.log('error');
                }
            });

        }, 2000);


        $('#sendText').click(function () {
            var textmassage=$('#textMassage').val();
            var username=$('#fullUserData').attr('data-username');
            var email=$('#fullUserData').attr('data-email');
            var name=$('#fullUserData').attr('data-fullname');
            var privilege=$('#fullUserData').attr('data-privilege');
            var path=$('#rootPath').val()+"doAction.php";

            //alert(textmassage + username + email + name + privilege + path);
            $.ajax({
                method:"POST",
                url:path,
                data:{
                    textmassage : textmassage ,
                    username : username ,
                    email : email ,
                    name : name ,
                    privilege : privilege ,
                },
                dataType:"html",
                success: function (data) {   // success callback function
                    console.log('success');
                    $('#textMassage').val('');
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback
                    console.log('error');
                }
            });
        });

        $(document).delegate('.deleteMassage','click',function () {
            var deleteid=$(this).attr('data-id');
            var path=$('#rootPath').val()+"doAction.php";

            $.ajax({
                method:"POST",
                url:path,
                data:{
                    deleteid : deleteid ,
                },
                dataType:"html",
                success: function (data) {   // success callback function
                    console.log('success');
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback
                    console.log('error');
                }
            });
        });


        /************************ work with modal form for change massages ************************/
        $('#closeMassageForm').click(function () {
            $('#changeMassageForm').hide();
        });

        $(document).delegate('.editMassage','click',function () {
            $('#changeMassageForm').css('display','flex');
            var arrayKey=$(this).attr('data-id');
            var username=$(this).attr('data-username');
            $('#changeMassageText').attr('data-id',arrayKey);
            $('#changeMassageText').attr('data-username',username);
        });

        $('#changeMassage').click(function () {
            var newmassage=$('#changeMassageText').val();
            var username=$('#changeMassageText').attr('data-username');
            var arraykey=$('#changeMassageText').attr('data-id');
            var path=$('#rootPath').val()+"doAction.php";

            //alert(textmassage + username + email + name + privilege + path);
            $.ajax({
                method:"POST",
                url:path,
                data:{
                    newmassage : newmassage ,
                    username : username ,
                    arraykey : arraykey ,
                },
                dataType:"html",
                success: function (data) {   // success callback function
                    console.log('success');
                    $('#changeMassageText').val('');
                    $('#changeMassageForm').hide();
                },
                error: function (jqXhr, textStatus, errorMessage) { // error callback
                    console.log('error');
                }
            });
        });


    });
</script>
</body>
</html>