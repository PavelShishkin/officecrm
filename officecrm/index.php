<?php

include "autoload.php"; 



if ($_SERVER['REQUEST_METHOD'] === 'GET') //  если GET запрос
{
    //выход
    if($location === "exit") 
    {
        $login = new login;
        $login->login_exit();
    }
    
    if($location == 'task_delete' ) 
    {
        $crm_task = new crm_task;
        $crm_task->task_delete($_GET['header'],$_GET['id'],$_GET['task_id']);
    }
    elseif($location == 'task_success' )
    {
        $crm_task = new crm_task;
        $crm_task->task_success($_GET['header'],$_GET['id'],$_GET['task_id']);
    }

    if(empty($_SESSION['user_id']) or empty($_SESSION['user_type']))//вход
    {
        include "views/login.php";
    }
    elseif(isset($_SESSION['user_type']))//иначе если вошли переходим на страницу
    {
        if($location === 'dashboard') // главная страница
        {
            include "views/index.php";
        }
        elseif($location === 'office')  // Добавление офиса (Админка)
        {
            if($_SESSION['user_type'] === '1' or $_SESSION['user_type'] === '2') // доступна только Админу и Директору иначе вывод ошибки для юзера
            {   
                include "views/crm-admin.html";
            }
            else
            {
                include "views/error_type_user.html";
            }
        }
        elseif($location == 'add_office')
        {
            if($_SESSION['user_type'] === '1' ) // доступна только Админу иначе вывод ошибки для юзера
            {   
                include "views/crm-office.html";
            }
            else
            {
                include "views/error_type_user.html";
            } 
        }
        elseif($location == 'profile') //страница настройки профиля
        {
            include "views/crm-profile.html";
        }
        elseif($location == 'profile_edit') // редактирование профиля 
        {
            include "views/crm-profile_edit.html";
        }
        elseif($location == 'kontragent') // добавление контрагента
        {
            include "views/crm-kontragent.html";
        }
        elseif($location == 'kontragent_one') //редактирование контрагента 
        {
            include "views/crm-kontragent_one.html";
        }
        elseif($location == 'contact')
        {
            include "views/crm-contact.html";
        }
        elseif($location == 'contact_one')
        {
            include "views/crm-contact_one.html";
        }
        elseif($location == 'change')
        {
            include "views/crm-change.html";
        }
        elseif($location == 'calendar')
        {
            include "views/crm-calendar.html";
        }
        else // если ни 1 из страниц не выбрана то показываем главную страницу
        {
            include "views/index.php";
        }
    }   
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST')//если POST запрос
{    
  

    //--------------------------------login(вход на сйт)-------------------------------------- 
   
    if(empty($_SESSION['user_id']) and empty($_SESSION['user_type']))  
    {
        $login = new login($_POST);          // создаю объект класса 
        $error = $login->login_error();      // обращаюсь к функции класса login
        include "views/login.php";           // после выполнения функций возвращаю на страницу  
    }

    //--------------------------------crm_office(работа с офисом)-------------------------------------- 
    
    //добавление офиса
    if($action == 'of_add_office' ) 
    {
        $crm_office = new crm_office($_POST);
        $error = $crm_office->of_required_office();

        if(sizeof($error)) //если есть ошибки
        {
            include "views/crm-office.html";
        }
        else
        {
            header("location: ?location=add_office");
        }
    }
    
    //удаление офиса
    if($action == 'of_delete_office' ) 
    {
        $crm_office = new crm_office;
        $crm_office->of_delete_office($_POST['office_id']);
        header("Location: ?location=add_office") ;
    }
    
    //редактирование (изменение) офиса
    if($action == 'of_update_office' ) 
    {
        $crm_office = new crm_office($_POST);
        $crm_office->of_update_office($_POST['of_id']);
        header("Location: ?location=add_office") ;
    }
    
    //изменение логотипа офиса
    if($action == 'of_update_avatar' ) 
    {
        $crm_office = new crm_office($_POST);
        $error = $crm_office->of_update_avatar($_FILES,$_POST['of_id']);
       
      
        if(sizeof($error)) //если есть ошибки
        {
            $modal = 'on_3';
            include "views/crm-office.html";
        }
        else
        {
            header("location: ?location=add_office");
        }
    }
    
    //вызов модального окна добавить офис 
    if($action === 'modal_add_office')
    {
        $modal = 'on_1';
        $office_id    = $_POST['of_id'];
        include "views/crm-office.html";
    }
    
    //вызов модального окна редактирование офиса 
    if($action === 'modal_edit_office')
    {
        $modal = 'on_2';
        include "views/crm-office.html";
    }
    
    //вызов модального окна загрузка изображения
    if($action === 'modal_image_office')
    {
        $modal = 'on_3';
        include "views/crm-office.html";
    }
    
    //--------------------------------crm_user(работа с сотрудниками)-------------------------------------- 
    
    //добавление сотрудника
    if($action === 'user_add_worker')
    {
        $crm_user = new crm_user($_POST);
        $error = $crm_user->user_required_worker();
        
        if(sizeof($error)) //если есть ошибки
        {
            $modal = 'on_1';
            include "views/crm-admin.html";
        }
        else
        {
            header("location: ?location=office");
        }
    }
    
    //изменеие информации о сотруднике по id
    if($action === 'user_edit_worker')
    {
        $crm_user = new crm_user($_POST);
        $error = $crm_user->user_required_edit_worker($_POST['user_id']);
        if(sizeof($error)) //если есть ошибки
        {
            $modal = 'on_2';
            include "views/crm-admin.html";
        }
        else
        {
            header("location: ?location=office");
        }
    }
    
    //удаление сотрудника
    if($action === 'user_delete_worker')
    {
        $crm_user = new crm_user;
        $crm_user->user_delete_worker($_POST['user_id']);
        header("Location: ?location=office");
    }
    
    //вызов модального окна добавление сотрудника 
    if($action === 'modal_add_worker')
    {
        $modal = 'on_1';
        include "views/crm-admin.html";
    }
    
    //вызов модального окна редактирование сотрудника 
    if($action === 'modal_edit_worker')
    {
        $modal = 'on_2';
        include "views/crm-admin.html";
    }
    
    //обновление профиля
    if($action === 'user_update_profile')  
    {
        $crm_user = new crm_user($_POST);
        $error    = $crm_user->user_required_profile();
        
        if(sizeof($error)) //если есть ошибки
        {
            include "views/crm-profile_edit.html";   
        }
        else
        {
            header("location: ?location=profile_edit");
        }  
    }
    
    //обновление пароля
    if($action === 'user_update_password') 
    {
        $crm_user = new crm_user($_POST);
        $error    = $crm_user->user_required_password();
        
        if(sizeof($error)) //если есть ошибки
        {
            include "views/crm-profile_edit.html";  
        }
        else
        {
            header("location: ?location=profile_edit");
        }
    }
    
    //смена аватарки
    if($action === 'user_update_avatar') 
    {
        $crm_user = new crm_user;
        $error    = $crm_user ->user_required_avatar($_FILES);
        
        if(sizeof($error)) //если есть ошибки
        {
            include "views/crm-profile_edit.html";  
        }
        else
        {
            header("location: ?location=profile_edit");
        }
    }
    
    //--------------------------------crm_contact(работа с контактами)-------------------------------------- 
    
    //включение дополнительных полей 
    if($action === 'cont_table')
    {
        $crm_contact = new crm_contact;
        $crm_contact->cont_table($_POST);
        header( "Location: ?location=contact");
    }
    
    //добавление контакта 
    if($action === 'cont_add_contact')
    {
        $crm_contact = new crm_contact($_POST);
        $error = $crm_contact->cont_required_contact();
       
        if(sizeof($error)) //если есть ошибки
        {
            include "views/crm-contact.html";   
        }
        else
        {
            header( "Location: ?location=contact");
        }    
    }
    
    //обновление имени и фамилии контакта 
    if($action === 'cont_update_name')
    {
        $crm_contact = new crm_contact;
        $crm_contact ->cont_update_name($_POST['cont_id'],$_POST['cont_name']); 
        header("Location: ?location=contact_one&id=".$_POST['cont_id']);
    }
    
    //обновление компании 
    if($action === 'cont_update_company')
    {
        $crm_contact = new crm_contact;
        $crm_contact ->cont_update_company($_POST['cont_id'],$_POST['cont_contragent']); 
        header("Location: ?location=contact_one&id=".$_POST['cont_id']);
    }
    
    //обновление должности
    if($action === 'cont_update_post')
    {
       $crm_contact = new crm_contact;
       $crm_contact ->cont_update_post($_POST['cont_id'],$_POST['cont_post']);
       header("Location: ?location=contact_one&id=".$_POST['cont_id']);
    }
    
    //обновление почты
    if($action === 'cont_update_email')
    {
       $crm_contact = new crm_contact;
       $crm_contact ->cont_update_email($_POST['cont_id'],$_POST['cont_email']);
       header("Location: ?location=contact_one&id=".$_POST['cont_id']);
    }
    
    //обновление почты
    if($action === 'cont_update_email_2')
    {
       $crm_contact = new crm_contact;
       $crm_contact ->cont_update_email_2($_POST['cont_id'],$_POST['cont_email_2']);
       header("Location: ?location=contact_one&id=".$_POST['cont_id']);
    }
    
    //обновление телефон 
    if($action === 'cont_update_phone')
    {
       $crm_contact = new crm_contact;
       $crm_contact ->cont_update_phone($_POST['cont_id'],$_POST['cont_phone']);
       header("Location: ?location=contact_one&id=".$_POST['cont_id']);
    }
    
    //обновление телефон 
    if($action === 'cont_update_phone_2')
    {
       $crm_contact = new crm_contact;
       $crm_contact ->cont_update_phone_2($_POST['cont_id'],$_POST['cont_phone_2']);
       header("Location: ?location=contact_one&id=".$_POST['cont_id']);
    }
    
    //обновление описания 
    if($action === 'cont_update_comment')
    {
       $crm_contact = new crm_contact;
       $crm_contact ->cont_update_comment($_POST['cont_id'],$_POST['cont_comment']);
       header("Location: ?location=contact_one&id=".$_POST['cont_id']);
    }
     
    
    
    
    //вывод дополнительных полей контрагент
    if($action === 'contr_table')
    {
        $crm_contragent = new crm_contragent ;
        $crm_contragent ->contr_table($_POST);
        header("Location: ?location=kontragent");
    }

    //добавление контрагента
    if($action === "add_kontragent")
    {
        $crm_contragent = new crm_contragent($_POST);
        $error          = $crm_contragent->contr_required_contragent();
        include "views/crm-kontragent.html";
    }
        
    if($action === "name_update")
    {
        $crm = new crm_contragent;
        $crm->name_update($_POST['contr_id'],$_POST['contr_name']);
    }
    
    if($action === "status_update")
    {
        $crm = new crm_contragent;
        $crm->status_update($_POST['contr_id'],$_POST['contr_status']);
    }
    if($action === "category_update")
    {
        $crm = new crm_contragent;
        $crm->category_update($_POST['contr_id'],$_POST['contr_category']);
    }
    
    if($action == 'stage_update')
    {
        $crm = new crm_contragent;
        $crm->stage_update($_POST['contr_id'],$_POST['contr_stage']);
    }
    
    if($action === "type_update")
    {
     
        $crm = new crm_contragent;
        $crm->type_update($_POST['contr_id'],$_POST['contr_type']);
    }
    
    if($action === 'responsible_update')
    {
        $crm = new crm_contragent;
        $crm->responsible_update($_POST['contr_id'],$_POST['contr_responsible']);
    }
    
    if($action === 'phone_update')
    {
        $crm = new crm_contragent;
        $crm->phone_update($_POST['contr_id'],$_POST['contr_phone']);
    }
    
    if($action === 'phone_update_2')
    {
        $crm = new crm_contragent;
        $crm->phone_update_2($_POST['contr_id'],$_POST['contr_phone_2']);
    }
    
    if($action === 'email_update')
    {
        $crm = new crm_contragent;
        $crm->email_update($_POST['contr_id'],$_POST['contr_email']);
    }
    
    if($action === 'email_update_2')
    {
        $crm = new crm_contragent;
        $crm->email_update_2($_POST['contr_id'],$_POST['contr_email_2']);
    }
    
    if($action === 'comment_update')
    {
        $crm = new crm_contragent;
        $crm->comment_update($_POST['contr_id'],$_POST['contr_comment']);
    }
    
    //--------------------------------crm_task(работа с задачами)--------------------------------------
    
    //добавление задачи
    if($action === 'task_add_task' ) 
    {
        
        $crm_task = new crm_task($_POST);
        $error = $crm_task->task_required_task();
        
        if(sizeof($error)) //если есть ошибки
        {
            $_GET['flag'] = 'up';
            
            if($_GET['location'] == 'contact_one')
            {
                include "views/crm-contact_one.html";
            }
            else
            {
                include "views/crm-kontragent_one.html";
            }
        }
        else
        {
            if($_GET['location'] == 'contact_one')
            {
                header("Location: ?location=contact_one&id=".$_GET['id']."&flag=up");
            }
            else
            {
                header("Location: ?location=kontragent_one&id=".$_GET['id']."&flag=up"); 
            }
        }
        
        
    }
    
    if($action === 'not_add_note' ) 
    {
        $crm_note = new crm_note($_POST);
        $crm_note->not_add_note($_GET['location'],$_GET['id']);
    }
    
    if($location == 'task_update' )
    {
        $crm_task = new crm_task($_POST);
        $crm_task->task_update($_GET['header'],$_GET['id'],$_GET['task_id']);
    }
    
    if($action == 'req_add_requisites')
    {
        $crm_requisites = new crm_requisites($_POST);
        $crm_requisites->req_add_requisites($_GET['contagent_id']);
    }
     
    if($action == 'file_upload')
    {
        $crm = new crm_contragent;
        $crm->file_upload($_FILES,$_GET['contragent_id']);
    }
    
    
    //Администраторская Изменение в БД 
    
    //изменение названия компании
    if($action == 'change_rename_company')
    {
        $crm = new crm_change($_POST);
        $error = $crm->change_required_rename();
        if(sizeof($error)) //если есть ошибки
        {
            include "views/crm-change.html";   
        }
        else
        {
            header( "Location: ?location=change");
        } 
    }
    
    //изменение логтипа компании
    if($action == 'change_update_avatar')
    {
        $crm = new crm_change;
        $error = $crm->change_update_avatar($_FILES);
        
        if(sizeof($error)) //если есть ошибки
        {
            include "views/crm-change.html";   
        }
        else
        {
            header( "Location: ?location=change");
        } 
    }
    
    //комментарий в шапке сайта
    if($action == 'change_comment_update')
    {
        $crm = new crm_change($_POST);
        $crm->change_comment_update();
        
        header( "Location: ?location=change");
    }
    
    //административная страница изменений ----------------
    
    //изменение статуса 
    if(@$_POST['action'] == 'status_update')
    {
        $crm = new crm_change($_POST);
        $crm->status_update();
        
        header( "Location: ?location=change&flag=status");
        
    }
    
    //удаление статуса 
    if(@$_POST['action'] == 'status_delete')
    {
        $crm = new crm_change($_POST);
        $crm->status_delete();
        
        header( "Location: ?location=change&flag=status");
        
    }
    
    //добовление статуса 
    if(@$_POST['action'] == 'status_add')
    {
        $crm = new crm_change($_POST);
        $crm->status_add();
        
        header( "Location: ?location=change&flag=status");
    }
    
     //изменение статуса дела
    if(@$_POST['action'] == 'stage_update')
    {
        $crm = new crm_change($_POST);
        $crm->stage_update();
        
        header( "Location: ?location=change&flag=stage");
    }
    
    //удаление статуса дела
    if(@$_POST['action'] == 'stage_delete')
    {
        $crm = new crm_change($_POST);
        $crm->stage_delete();
        
        header( "Location: ?location=change&flag=stage");
    }
    
    //добовление статуса дела
    if(@$_POST['action'] == 'stage_add')
    {
        $crm = new crm_change($_POST);
        $crm->stage_add();
        
        header( "Location: ?location=change&flag=stage");   
    }
    
    
     //изменение категории
    if(@$_POST['action'] == 'categor_update')
    {
        $crm = new crm_change($_POST);
        $crm->categor_update();
        
        header( "Location: ?location=change&flag=categor");
    }
    
    //удаление категории
    if(@$_POST['action'] == 'categor_delete')
    {
        $crm = new crm_change($_POST);
        $crm->categor_delete();
        
        header( "Location: ?location=change&flag=categor");
    }
    
    //добовление категории
    if(@$_POST['action'] == 'categor_add')
    {
        $crm = new crm_change($_POST);
        $crm->categor_add();
        
        header( "Location: ?location=change&flag=categor");   
    }
    
    
    //изменение должности
    if(@$_POST['action'] == 'post_update')
    {
        $crm = new crm_change($_POST);
        $crm->post_update();
        
        header( "Location: ?location=change&flag=post");
    }
    
    //удаление должности
    if(@$_POST['action'] == 'post_delete')
    {
        $crm = new crm_change($_POST);
        $crm->post_delete();
        
        header( "Location: ?location=change&flag=post");
    }
    
    //добовление должности
    if(@$_POST['action'] == 'post_add')
    {
        $crm = new crm_change($_POST);
        $crm->post_add();
        
        header( "Location: ?location=change&flag=post");   
    }
    
    
    //изменение типа контрагента
    if(@$_POST['action'] == 'contr_type_update')
    {
        $crm = new crm_change($_POST);
        $crm->contr_type_update();
        
        header( "Location: ?location=change&flag=contr_type");
    }
    
    //удаление типа контрагента
    if(@$_POST['action'] == 'contr_type_delete')
    {
        $crm = new crm_change($_POST);
        $crm->contr_type_delete();
        
        header( "Location: ?location=change&flag=contr_type");
    }
    
    //добовление типа контрагента
    if(@$_POST['action'] == 'contr_type_add')
    {
        $crm = new crm_change($_POST);
        $crm->contr_type_add();
        
        header( "Location: ?location=change&flag=contr_type");   
    }
    
    
   
}



    
