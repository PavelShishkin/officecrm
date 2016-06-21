<?php

@$location = make_safe_html($_GET['location']);                           //локация
@$action   = make_safe_html($_GET['action']);                             //действие
@$filter   = make_safe_html($_GET['filter']);                             //фильтр  (Офис и Сотрудники)
@$flag     = make_safe_html($_GET['flag']);  
@$status   = make_safe_html($_GET['status']);  




if($filter == ""){$filter = '*';} //если филтр не установлен фильтрую по всем пользователям

//Разделение прав и подключение страниц 
if(@$_SESSION['user_type'] === '1')//Админ
{
    $user        = "views/crm_user/user.php";
    $aside       = "views/crm_menu/admin_aside.php";
    $add_worker  = "views/crm_worker/admin_add_worker.php";
    $edit_worker = "views/crm_worker/admin_edit_worker.php";
    $profile_edit= "views/crm_profile_edit/admin_profile_edit.php";
    $update      = "views/crm_update/crm_update.php";
    $note        = "views/crm_notes/crm_notes.php";
    $task        = "views/crm_task/crm_task.php";
    
}
elseif(@$_SESSION['user_type'] === '2')//Директор
{
    $user        = "views/crm_user/user.php";
    $aside       = "views/crm_menu/director_aside.php";
    $add_worker  = "views/crm_worker/director_add_worker.php";
    $edit_worker = "views/crm_worker/director_edit_worker.php";
    $profile_edit= "views/crm_profile_edit/admin_profile_edit.php";
    $update      = "views/crm_update/crm_update.php";
    $note        = "views/crm_notes/crm_notes.php";
    $task        = "views/crm_task/crm_task.php";
}
elseif(@$_SESSION['user_type'] === '3')//Юзер
{
    $user        = "views/crm_user/user.php";
    $aside       = "views/crm_menu/user_aside.php";
    $profile_edit= "views/crm_profile_edit/user_profile_edit.php";
    $update      = "views/crm_update/crm_update.php";
    $note        = "views/crm_notes/crm_notes.php";
    $task        = "views/crm_task/crm_task.php";
}






