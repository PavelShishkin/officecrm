<?php

//-----------------------подключение к БД----------------------------------------------------------------------------------------------------------------
class database_config
{
  private $dbname   = 'db_crm';  
  private $username = 'root';    
  private $password = ''; 
  private $dbo;
   
  protected function dbo()
  {
    try
    {
        if (!$this->dbo)  //если подключение отсутствует то подключаюсь
        {
            $this->dbo = new PDO('mysql:host=localhost;dbname=' . $this->dbname, $this->username, $this->password);
            $this->dbo->exec('SET NAMES "utf8";');
        }
        
        return $this->dbo;
    }
    catch(Exception $error) // если есть ошибка в подключении, редирект на страницу ошибки подключения 
    {
        header("Location: views/error_db.html"); //вывод ошибки 
    }
  }
}

//-----------------------получение данных из БД----------------------------------------------------------------------------------------------------------
class database extends database_config
{
    
    // фильтр cотрудников по алфавиту + офису
    public function db_get_filter_user($filter)
    {
        $dbo = $this->dbo();
        
        if($_SESSION['user_type'] === '1')
        {
            if($filter === '*')                   //показать всех сотрудников
            {
                $sql = $dbo->query('SELECT * FROM `crm_users`;'); 
                $array_users = $sql->fetchAll(PDO::FETCH_ASSOC); 
            }
            else                                  //иначе показать сотрудника по 1-ой букве фамилии 
            {
                $sql = $dbo->query('SELECT * FROM `crm_users` where LEFT(`user_lastname`,1) = "'.$filter.'";'); 
                $array_users = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        else
        {
            if($filter === '*')                   
            {
                $sql = $dbo->query('SELECT * FROM `crm_users` where user_office="'.$_SESSION['user_office'].'";'); 
                $array_users = $sql->fetchAll(PDO::FETCH_ASSOC); 
            }
            else                                 
            {
                $sql = $dbo->query('SELECT * FROM `crm_users` 
                                             where user_office="'.$_SESSION['user_office'].'" 
                                             and LEFT(`user_lastname`,1) = "'.$filter.'";'); 
                $array_users = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        return $array_users;
    }
    
    //фильтр по офису
    public function db_get_filter_office($filter)
    {
        $dbo = $this->dbo();
        
        if($filter === '*') //показать все офисы
        {
            $sql = $dbo->query('SELECT * FROM `crm_office` ;'); 
            $array_offices = $sql->fetchAll(PDO::FETCH_ASSOC); 
        }
        else               // иначе показать офис по 1-ой букве 
        {
            $sql = $dbo->query('SELECT * FROM `crm_office` WHERE LEFT(`of_name`,1) = "'.$filter.'";'); 
            $array_offices = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $array_offices;
    }
    
    //получение офисов
    public function db_get_office()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_office`;'); 
        $array_offices = $sql->fetchAll(PDO::FETCH_ASSOC); 
       
        return $array_offices;
    }
    
    //получение офиса по id
    public function db_get_office_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_office` where of_id='.$id.';'); 
        $array_office = $sql->fetchAll(PDO::FETCH_ASSOC); 
       
        return $array_office;
    }
    
    //получение имени офиса по id
    public function db_get_officename($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT `of_name` FROM `crm_office` where of_id="'.$id.'";'); 
        $array_office = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach($array_office as $office)
        {
            return $office['of_name']; 
        }
    }
    
    //получить должность 
    public function db_get_post()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_posts`;'); 
        $array_posts = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_posts;
    }
    
    //получить имя должности по id
    public function db_get_postname($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_posts` where post_id="'.$id.'";'); 
        $array_post = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_post as $name)
        {
            $array_post = $name['post_name'];
        }
        
        if(empty($array_post))
        {
            $array_post = '-';
        }
        
        return $array_post;
    }
    
    //получение контрагентов
    public function db_get_contragent()
    {
        $dbo = $this->dbo();
        
        if($_SESSION['user_type'] !== '1')
        {
            $sql = $dbo->query('SELECT * FROM `crm_contragents` where contr_office_id="'.$_SESSION['user_office'].'";');
        }
        else
        {
            $sql = $dbo->query('SELECT * FROM `crm_contragents`;');
        }

        $array_contragents = $sql->fetchAll(PDO::FETCH_ASSOC);
       
        return $array_contragents;
    }
    
    //получение контактов 
    public function db_get_contact()
    {
       
        $dbo = $this->dbo();
        if($_SESSION['user_type'] !== '1')
        {
            $sql = $dbo->query('SELECT * FROM `crm_contacts` where cont_office_id="'.$_SESSION['user_office'].'";'); 
        }
        else
        {
            $sql = $dbo->query('SELECT * FROM `crm_contacts`;'); 
        }
        
        $array_contacts = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_contacts;
    }
    
    //получение контакта по id 
    public function db_get_contact_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_contacts` where cont_id='.$id.';' ); 
        $array_contact = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_contact;
    }
    
    //вывод всех пользователей
    public function db_get_user()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_users`;'); 
        $array_users = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_users;
    }
    
    //получение категории 
    public function db_get_category()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_categorys`;'); 
        $array_categorys = $sql->fetchAll(PDO::FETCH_ASSOC); 
       
        return $array_categorys;
    }
    
    //получение изменений контрагента по id
    public function db_get_update_contragent($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_updates` where contragent_id="'.$id.'";'); 
        $array_updates = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_updates;
    }
    
    //получение изменений контакта по id
    public function db_get_update_contact($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_updates` where contact_id="'.$id.'";'); 
        $array_updates = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_updates;
    }
    
    
    public function db_get_stage_name($id)
    {
        $dbo = $this->dbo();
        
        $sql = $dbo->query('SELECT * FROM `crm_business_stage` where stage_id="'.$id.'";'); 
        $array_stage = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach($array_stage as $stage)
        {
            $stage_name = $stage['stage_name'];
        }
        
        return $stage_name;
    }
    
    //показываю всю информацию о юзере по id
    public function db_get_user_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_users` where `user_id`='.$id.';'); 
        $array_users = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_users;
    }
    
    //показываю всю информацию о контрагенте по id
    public function db_get_contragent_id($id)
    {
        $dbo = $this->dbo();
        
        $sql = $dbo->query('SELECT * FROM `crm_contragents` where `contr_id`='.$id.';');
        
        $array_contragents = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_contragents;
    }
    
    //показываю имя контрагента по id
    public function db_get_contragentname($id) 
    {
        if($id == '' or $id == null or $id == 0)
        {
            $contr_name = '';
        }
        else
        {
            $dbo = $this->dbo();
            $sql = $dbo->query('SELECT contr_name FROM `crm_contragents` where `contr_id`='.$id.';'); 
            $array_contragent = $sql->fetchAll(PDO::FETCH_ASSOC); 

            foreach( $array_contragent as $name)
            {
                $contr_name = $name['contr_name'];
            }
        }
        
        return $contr_name;
    }
    
    //показываю имя по id
    public function db_get_user_name($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT user_name FROM `crm_users` WHERE user_id="'.$id.'";'); 
        $array_name = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_name as $name)
        {
            $user_name = $name['user_name'];
        }
        
        return $user_name;    
    }
    
    public function db_get_id()
    {      
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_contragents` ORDER BY `crm_contragents`.`contr_id` DESC;'); 
        $array_id = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_id as $id)
        {
            $contr_id = $id['contr_id'];
             return $contr_id;
        }
        
       

    }
    
    //показываю 
    public function db_get_stage()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_business_stage`;'); 
        $array_stage = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_stage;    
    }
    
    //показываю имя по id
    public function db_get_stage_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT stage_name FROM `crm_business_stage` WHERE stage_id="'.$id.'";'); 
        $array_stage = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_stage as $stage)
        {
            $stage_name = $stage['stage_name'];
        }
        
        return $stage_name;    
    }
    
     //показываю аватарку по id
    public function db_get_avatar_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT user_avatar FROM `crm_users` WHERE user_id="'.$id.'";'); 
        $array_user = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_user as $user)
        {
            $user_avatar = $user['user_avatar'];
        }
        
        if(empty($user_avatar))
        {
            $user_avatar = 'error.jpg';
        }
        return $user_avatar;    
    }
    
    //показываю фамилию по id
    public function db_get_user_lastname($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT user_lastname FROM `crm_users` WHERE user_id="'.$id.'";'); 
        $array_lastname = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_lastname as $lastname)
        {
            $user_lastname = $lastname['user_lastname'];
        }
        
        return $user_lastname;    
    }

    //показываю имя и фамилию по id
    public function db_get_username($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT user_name,user_lastname FROM `crm_users` WHERE user_id="'.$id.'";'); 
        $array_name = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_name as $name)
        {
            $user_name = $name['user_name'].' '.$name['user_lastname'];
        }
        
        if(empty($user_name))
        {
            $user_name = "";
        }
        return $user_name;    
    }
    
    //показываю имя категории по id
    public function db_get_categorname($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT categor_name FROM `crm_categorys` WHERE categor_id="'.$id.'";'); 
        $array_name = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_name as $name)
        {
            $categor_name = $name['categor_name'];
        }
        
        if(empty($array_name))
        {
            $categor_name='';
        }
        
        
        return $categor_name;    
    }
    
    //показываю заметки контатка по id
    public function db_get_note_contact_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_notes` WHERE not_contact_id="'.$id.'";'); 
        $array_notes = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_notes;  
    }
    
    //показываю заметки контрагента по id
    public function db_get_note_contragent_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_notes` WHERE not_contragent_id="'.$id.'";'); 
        $array_notes = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_notes;  
    }
    
    //показываю  задачи
    public function db_get_task()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_tasks` ORDER BY `task_datetime` DESC;'); 
        
        
        $array_tasks = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_tasks as $task)
        {
            if( $task['task_datetime'] < date("Y-m-d H:i:s") and  $task['task_name'] !== "Выполнено" and $task['task_name'] !== "Просрочено"  and $task['task_name'] !== "Не выполнено")
            {
                      $sql2 = $dbo->prepare("UPDATE `crm_tasks` SET task_name='Просрочено' WHERE task_id='".$task['task_id']."';");
                      $sql2 ->execute();
            }
        }

        return $array_tasks;    
    }
    
    public function db_get_task_contragent()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_tasks` where task_contragent_id<>0;');
        $array_tasks = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_tasks as $task)
        {
            if( $task['task_datetime'] < date("Y-m-d H:i:s") and  $task['task_name'] !== "Выполнено" and $task['task_name'] !== "Просрочено" and $task['task_name'] !== "Не выполнено")
            {
                      $sql2 = $dbo->prepare("UPDATE `crm_tasks` SET task_name='Просрочено' WHERE task_id='".$task['task_id']."';");
                      $sql2 ->execute();
            }
        }
        
        return  $array_tasks;    
    }
    
    public function db_get_task_contact()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_tasks` where task_contact_id<>0;'); 
        $array_tasks = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach( $array_tasks as $task)
        {
            if( $task['task_datetime'] < date("Y-m-d H:i:s") and  $task['task_name'] !== "Выполнено" and $task['task_name'] !== "Просрочено" )
            {
                      $sql2 = $dbo->prepare("UPDATE `crm_tasks` SET task_name='Просрочено' WHERE task_id='".$name['task_id']."';");
                      $sql2 ->execute();
            }
        }
        
        
        return  $array_tasks;    
    }
    
    public function db_get_task_id($id)
    {
        $dbo = $this->dbo();
        
        
            $sql = $dbo->query('SELECT * FROM `crm_tasks` where task_id="'.$id.'";');
        
        
        $array_tasks = $sql->fetchAll(PDO::FETCH_ASSOC); 

        return  $array_tasks;    
    }
    
    public function db_get_task_author_id($id)
    {
        $dbo = $this->dbo();
       
        $sql = $dbo->query('SELECT * FROM `crm_tasks` where task_author="'.$id.'";');

        $array_tasks = $sql->fetchAll(PDO::FETCH_ASSOC); 

        return  $array_tasks;    
    }
    
    public function db_get_task_contragent_id($id)
    {
        $dbo = $this->dbo();
        
       
        $sql = $dbo->query('SELECT `task_name` FROM `crm_tasks` where task_contragent_id="'.$id.'";'); 
       
        
        $array_tasks = $sql->fetchAll(PDO::FETCH_ASSOC); 
       
        foreach($array_tasks as $name)
        {
            if($name['task_name'] !== 'Выполнено')
            {
                $array_name = $name['task_name'];
            }
        }
        
      
        if(empty($array_name))
        {
            $array_name ='';
        }
        
        return  $array_name;    
    }
    
    public function db_get_task_contragents_id($id)
    {
        $dbo = $this->dbo();
        
        $sql = $dbo->query('SELECT * FROM `crm_tasks` where task_contragent_id="'.$id.'";'); 
        
        $array_tasks = $sql->fetchAll(PDO::FETCH_ASSOC); 
       
        return $array_tasks ;
    }
    
    public function db_get_task_contact_id($id)
    {
        $dbo = $this->dbo();
        
        $sql = $dbo->query('SELECT * FROM `crm_tasks` where task_contact_id="'.$id.'";'); 
    
        $array_tasks = $sql->fetchAll(PDO::FETCH_ASSOC); 
       
        return $array_tasks ;
    }
    
    //вывод ближайшей задачи контрагента
    public function db_get_task_nearest_contragent_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_tasks` where task_contragent_id="'.$id.'"  ORDER BY `task_datetime` DESC;'); 
        $array_tasks = $sql->fetchAll(PDO::FETCH_ASSOC); 

        
        foreach($array_tasks as $name)
        {
            if($name['task_datetime'] < date("Y-m-d H:i:s") and  $name['task_name'] !== "Выполнено" and $name['task_name'] !== "Просрочено" and $name['task_name'] !== "Не выполнено")
            {
                  $sql2 = $dbo->prepare("UPDATE `crm_tasks` SET task_name='Просрочено' WHERE task_id='".$name['task_id']."';");
                  $sql2 ->execute();
           
                  $array_name = $name['task_datetime']." ".$name['task_name'];
                  return $array_name;
            }
        }
        
        if(empty($array_name))
        {
            foreach($array_tasks as $name)
            {
                if($name['task_name'] == 'Просрочено'  or $name['task_name'] == "Не выполнено" )
                {
                    $array_name = $name['task_datetime']." ".$name['task_name'];
                    return $array_name;
                }
            }
            
        }
        
        
        if(empty($array_name))
        {
            foreach($array_tasks as $name)
            {
                if($name['task_name'] !== 'Выполнено'  or $name['task_date'] < date("Y-m-d"))
                {
                    $array_name = $name['task_datetime']." ".$name['task_name'];
                    return $array_name;
                }
            }
            
        }
        
        
        
        if(empty($array_name))
        {
            $array_name = 'Задач нету';
        }
        
        return  $array_name;   
    }
    
    
    //вывод ближайшей задачи  контакта
    public function db_get_task_nearest_contact_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_tasks` where  task_contact_id="'.$id.'" ORDER BY `task_datetime` DESC;'); 
        $array_tasks = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach($array_tasks as $name)
        {
            if($name['task_datetime'] < date("Y-m-d H:i:s") and  $name['task_name'] !== "Выполнено" and $name['task_name'] !== "Просрочено" and $name['task_name'] !== "Не выполнено")
            {
                  $sql2 = $dbo->prepare("UPDATE `crm_tasks` SET task_name='Просрочено' WHERE task_id='".$name['task_id']."';");
                  $sql2 ->execute();

                  $array_name = $name['task_datetime']." ".$name['task_name'];
                  return $array_name;
            }
        }
        
        if(empty($array_name))
        {
            foreach($array_tasks as $name)
            {
                if($name['task_name'] == 'Просрочено'  or $name['task_name'] == "Не выполнено" )
                {
                    $array_name = $name['task_datetime']." ".$name['task_name'];
                    return $array_name;
                }
            }
            
        }
        
        
        if(empty($array_name))
        {
            foreach($array_tasks as $name)
            {
                if($name['task_name'] !== 'Выполнено'  or $name['task_date'] < date("Y-m-d"))
                {
                    $array_name = $name['task_datetime']." ".$name['task_name'];
                    return $array_name;
                }
            }
            
        }
        
       
        
        
        
        if(empty($array_name))
        {
            $array_name = 'Задач нету';
        }
        
        return  $array_name;     
    }
    
    //показываю  реквизиты
    public function db_get_requisites()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_requisites`;'); 
        $array_requisites = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
       
        
        return $array_requisites;    
    }
    
    //показываю  реквизиты по id
    public function db_get_requisites_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_requisites` where req_contragent_id="'.$id.'";'); 
        $array_requisites = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_requisites;    
    }
    
     //показываю  файлы по id
    public function db_get_file_id($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_files` where file_contragent_id="'.$id.'";'); 
        $array_files = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_files;    
    }
    
    //вывод статуса по умолчанию новый
    public function db_get_status()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_status`;'); 
        $array_status = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        return $array_status;    
    }
    
    //вывод имени компании
    public function db_get_name_company()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_company`;'); 
        $array_name = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach($array_name as $name)
        {
            $name_company = $name['company_name'];
        }
        
        return $name_company;    
    }
    
    //вывод логотипа компании
    public function db_get_image_company()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_company`;'); 
        $array_image = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach($array_image as $image)
        {
            $image_company = $image['company_image'];
        }
        
        return $image_company;    
    }
    
    //вывод типа контрагента
    public function db_get_contr_type()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_contr_type`;'); 
        $array_types = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
      
        
        return $array_types;    
    }
    
    //вывод коментария компании
    public function db_get_comment_company()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_company`;'); 
        $array_comment = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach($array_comment as $comment)
        {
            $image_comment = $comment['company_comment'];
        }
        
        return $image_comment;    
    }
    
    //вывод офиса компании
    public function db_get_office_company()
    {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_office` where of_id="'.$_SESSION['user_office'].'";'); 
        $array_office = $sql->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach($array_office as $office)
        {
            $office_name = $office['of_name'];
        }
        
        if(empty($office_name))
        {
            $office_name = '';
        }
        return $office_name;    
    }
    
}

//-----------------------Вход на сайт--------------------------------------------------------------------------------------------------------------------
class login extends database_config 
{
    private $login_email;   //логин 
    private $login_password;//пароль
    
    public $errors = [];    //массив с ошибками 
    
    //проверка входных данных
    public function __construct($login_post = null)
    {
        if ($login_post !== null && is_array($login_post))
        {
            $this->login_email    = trim(array_get($login_post, 'login_email'));          
            $this->login_password = trim(array_get($login_post, 'login_password'));
        }
    }
    
    //регулярка
    public function login_error()
    {
        if($this->login_email === '')                              
        {
            $this->errors['login_email'] = "Введите email";
        }
        elseif(!filter_var($this->login_email, FILTER_VALIDATE_EMAIL))
        {
            $this->errors['login_email'] = "Введен некорректный email";
        }
        
        if($this->login_password === '')
        {
            $this->errors['login_password'] = "Введите пароль";
        }
        elseif(mb_strlen($this->login_password,'UTF-8') < 5)
        {
            $this->errors['login_password'] = "Введен некорректный пароль";
        }
        
        if(empty($this->errors)) // если ошибок нет проверяю логин и пароль 
        {  
            $errors = $this->login_required();
            return $errors;
        }
        else
        {
            return $this->errors; // иначе вывожу ошибки 
        }
    }
    
    //вход, проверка логина и пароля 
    private function login_required()
    {
        $login        = $this->login_email;
        $password_md5 = md5($this->login_password);

        //подключаюсь к БД
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT * FROM `crm_users` where user_email="'.$login.'" and user_password_md5 ="'.$password_md5.'";');
        $array_users = $sql->fetchAll(); 
        
        //если БД не нашла совподений вывожу ошибку, иначе записываю данные о пользователе в сессию
        if(empty($array_users)) 
        {
            $this->errors['login_error'] = "Такого логина и пароля не существует";
            return $this->errors;   
        }
        else
        {
            foreach($array_users as $user) 
            {               
                $_SESSION['user_id']           = $user['user_id']; 
                $_SESSION['user_type']         = $user['user_type'];
                $_SESSION['user_office']       = $user['user_office'];
                
                $_SESSION['cont_name']         = 1;
                $_SESSION['cont_phone']        = 1;
                $_SESSION['cont_email']        = 1;
                $_SESSION['cont_status']       = 1;
                
               
                $_SESSION['contr_name']        = 1;
                
                $_SESSION['contr_phone']       = 1;
                $_SESSION['contr_email']       = 1;
                $_SESSION['contr_categor']     = 1;
               
                $_SESSION['contr_avtor']       = 1;
            }
            
            header("Location: ?location=dashboard"); //редирект на главную страницу 
        }
     }
    
     //выход
     public function login_exit()
     {
         $_SESSION = array();
         session_destroy();
     }
    
     
}

//-----------------------crm_office(Добавление офиса в БД (редактирование офиса))------------------------------------------------------------------------
class crm_office extends database_config
{
    public $of_name;    //название офиса
    public $of_country; //страна
    public $of_city;    //город
    public $of_phone;   //телефон офиса
    public $of_image;   //логотип офиса 
    
    protected $errors = []; //массив с ошибками
    
    //конструктор принемающий входные данные 
    public function __construct($of_post = null) 
    {
        if ($of_post !== null && is_array($of_post))
        {   
            $this->of_name 	   = trim(array_get($of_post, 'of_name')); 
            $this->of_country  = trim(array_get($of_post, 'of_country')); 
            $this->of_city 	   = trim(array_get($of_post, 'of_city'));
            $this->of_phone    = trim(array_get($of_post, 'of_phone'));
            $this->of_image    = 'office.jpg'; // по умолчанию стандартное изображение 
        }
    }
    
    //регуляка (проверка введеных данных пользователем)
    public function of_required_office()
    {
        $this->of_add_office();
        
        if(isset($this->errors)) //если есть ошибки вывожу их 
        {
            return $this->errors;
        }
    }
    
    //добавление офиса в БД 
    private function of_add_office()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_office` 
                                        (`of_name`, `of_country`,`of_city`, `of_phone`,`of_image`) 
                              VALUES
                                        ('".$this->of_name."', '".$this->of_country."', '".$this->of_city."', '".$this->of_phone."','".$this->of_image."')");
        $sql ->execute();
    }
    
    //редактирование(обнавление) офиса по id
    public function of_update_office($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_office` SET of_name='".$this->of_name."', 
                                                       of_country='".$this->of_country."', 
                                                       of_city='".$this->of_city."',
                                                       of_phone='".$this->of_phone."'
                              WHERE of_id='".$id."';");
        
        $this->of_update_user_office($id); 
        $sql ->execute();
    }
    
    //обновление информации сотрудников прикрепленных к офису 
    public function of_update_user_office($id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_users` SET   user_country='".$this->of_country."', 
                                                       user_city='".$this->of_city."',
                                                       user_office_phone='".$this->of_phone."'
                              WHERE user_office='".$id."';");
        $sql ->execute();
        
    }
    
    //удаление офиса по id
    public function of_delete_office($id)
    {
        $dbo = $this->dbo();  
        $sql = $dbo->prepare("DELETE FROM  `crm_office` WHERE of_id='".$id."';");
        $sql ->execute();            //удаляю офис  
        $this->of_delete_user($id); // удаляю сотрудников этого офиса 
    }
    
    //удаление сотрудников офиса по id офиса 
    public function of_delete_user($id)
    {
        $dbo = $this->dbo();  
        $sql = $dbo->prepare("DELETE FROM  `crm_users` WHERE user_office='".$id."';");
        $sql ->execute(); //удаляю сотрудников  
    }
    
    //загрузка логотипа офиса 
    public function of_update_avatar($file,$id)
    {
         if($file["of_avatar"]["size"] > 1024*3*1024)
         {
             return $this->errors['of_avatar']="Размер файла превышает три мегабайта!";
         }
         
         if(($file["of_avatar"]["type"] !== "image/jpeg") and ($file["of_avatar"]["type"] !== "image/png") )
         {  
             return $this->errors['of_avatar']="Загрузите изображение в формате png или jpeg!";
         }
    
         list($width, $height) = getimagesize( $file['of_avatar']["tmp_name"] );
        
         if(($width !== 200) and ($height !== 200) )
         {
             return $this->errors['of_avatar']="Изображение должно иметь размер 200x200 !";
         }
                
         if(empty($this->errors['of_avatar']))
         {
             // Проверяем загружен ли файл
             if(is_uploaded_file($file['of_avatar']["tmp_name"]))
             {
                // Если файл загружен успешно, перемещаем его
                // из временной директории в конечную
                $filename = $_SESSION['user_id'] . rand().$file['of_avatar']["name"];
              
                move_uploaded_file($file['of_avatar']["tmp_name"], "views/image_office/".$filename);
                
                $dbo = $this->dbo();
                $sql = $dbo->prepare("UPDATE `crm_office` SET of_image='". $filename."' where of_id='".$id."';");
                $sql->execute();
             } 
             else 
             {
                $this->errors['of_avatar']="Ошибка загрузки файла";
             }
         }
    }    
}



//-----------------------crm_user(Добавление новых сотрудников и обновление профиля пользователя)--------------------------------------------------------
class crm_user extends database_config
{
    public  $user_name;             //имя пользователя
    public  $user_lastname;         //Фамилия
    public  $user_type;             //тип пользователя (Админ, Директор, Юзер)
    public  $user_email;            //почта
    public  $user_phone;            //телефон
    public  $user_office;           //офис
    public  $user_post;             //должность
    public  $user_birthday;         //день рождение
    public  $user_avatar;           //аватарка (фото)
    private $user_password;         //пароль
    
    private $user_new_password;     //новый пароль
    private $user_new_password_one; //подтверждение нового пароля
    
    public $errors = [];            //массив с ошибками 
    
    //проверка входных данных
    public function __construct($user_post = null) 
    {
        if ($user_post !== null && is_array($user_post))
        {
            $this->user_name  		     = trim(array_get($user_post, 'user_name'));             //имя
            $this->user_lastname  		 = trim(array_get($user_post, 'user_lastname'));         //фамилия
            $this->user_type 		     = trim(array_get($user_post, 'user_type'));             //тип пользователя
            $this->user_email            = trim(array_get($user_post, 'user_email'));            //почта
            $this->user_phone            = trim(array_get($user_post, 'user_phone'));            //телефон
            $this->user_office           = trim(array_get($user_post, 'user_office'));           //офис
            $this->user_post	         = trim(array_get($user_post, 'user_post'));             //должность
            $this->user_birthday		 = trim(array_get($user_post, 'user_birthday'));         //день рождение 
            $this->user_password         = trim(array_get($user_post, 'user_password'));         //пароль
            $this->user_avatar           = empty($user_post['user_avatar']) ? 'profile-avatar.jpg' : $user_post['user_avatar']; //аватарка
            
            $this->user_new_password     = trim(array_get($user_post, 'user_new_password'));     //новый пароль
            $this->user_new_password_one = trim(array_get($user_post, 'user_new_password_one')); //повтор нового пароля
        }
    }
    
     //регулярка
     public function user_required_worker()
     {
            $database = new database;  
            $array_users= $database->db_get_user();
            foreach($array_users as $user)
            {
                if($this->user_email === $user['user_email'])
                {
                    $this->errors['user_email'] = 'Такой email уже используется.';
                    return $this->errors;
                }
            }
         
            if($this->user_email === '')
            {
                $this->errors['user_email'] = 'Это поле обязательно для заполнения.';
            }
         
            if($this->user_password === '')
            {
                $this->errors['user_password'] = 'Это поле обязательно для заполнения.';
            }
            elseif(mb_strlen($this->user_password ,'UTF-8') < 5)
            {
                $this->errors['user_password'] = 'Пароль должен состоять минимум из 5 символов.';
            }
         
            if($this->user_office === '')
            {
                $this->errors['user_office'] = 'Создайте офис.';
            }
         
        
            if(empty($this->errors))     //если нет ошибок
            {
                $this->user_add_worker();
            }
            else                         
            {
                return $this->errors;
            }
     }
    
     //добавление офиса в БД
     private function user_add_worker()
     {
        // если это админ то в статусе ставлю 0
        if($_SESSION['user_type'] === '1')
        {
            $user_status_add_id = '0';
        }
        else
        {
            $user_status_add_id = $_SESSION['user_id'];
        }
         
        $dbo = $this->dbo();
        $database = new database;   
        $array_ofice= $database->db_get_office_id($this->user_office); //получение информации о офисе по id
        foreach($array_ofice as $office)
        {
            $sql = $dbo->prepare("INSERT INTO `crm_users` 
                                        (`user_name`    ,`user_lastname`, 
                                         `user_country` ,`user_city`, 
                                         `user_office`  ,`user_birthday`, 
                                         `user_post`    ,`user_email`, 
                                         `user_phone`   ,`user_office_phone`, 
                                         `user_type`    ,`user_password`,
                                         `user_avatar`  ,`user_password_md5`,
                                         `user_status_add_id`) 
                              VALUES
                                        ('".$this->user_name."', '".$this->user_lastname."', 
                                        '".$office['of_country']."', '".$office['of_city']."', 
                                        '".$office['of_id']."', '".$this->user_birthday."', 
                                        '".$this->user_post."', '".$this->user_email."', 
                                        '".$this->user_phone."', '".$office['of_phone']."', 
                                        '".$this->user_type."','".$this->user_password."',
                                        '".$this->user_avatar."','".md5($this->user_password)."',
                                        '".$user_status_add_id."')");
            
           
        }
        
        $sql->execute();
     }
    
     //регулярка изменение сотрудника
     public function user_required_edit_worker($id)
     {
            $database = new database;  
            $array_users= $database->db_get_user();
            foreach($array_users as $user)
            {
                if($this->user_email === $user['user_email'] and $id !== $user['user_id'] )
                {
                    $this->errors['user_email'] = 'Такой email уже используется.';
                    return $this->errors;
                }
            }
         
            if($this->user_email === '')
            {
                $this->errors['user_email'] = 'Это поле обязательно для заполнения.';
            }
         
            if($this->user_password === '')
            {
                $this->errors['user_password'] = 'Это поле обязательно для заполнения.';
            }
            elseif(mb_strlen($this->user_password ,'UTF-8') < 5)
            {
                $this->errors['user_password'] = 'Пароль должен состоять минимум из 5 символов.';
            }
         
            if($this->user_office === '')
            {
                $this->errors['user_office'] = 'Создайте офис.';
            }
         
        
            if(empty($this->errors))     //если нет ошибок
            {
                $this->user_edit_worker($id);
            }
            else                         
            {
                return $this->errors;
            }
     }
     
     //изменение информации о сотруднике 
     private function user_edit_worker($id)
     {
        $dbo = $this->dbo();
        $database = new database; 
        $array_ofice= $database->db_get_office_id($this->user_office); //получение информации о офисе по id
        
        foreach($array_ofice as $office)
        {
            $sql = $dbo->prepare("UPDATE `crm_users` SET user_name='".$this->user_name."', user_lastname='".$this->user_lastname."', 
                                                     user_post='".$this->user_post."', user_email='".$this->user_email."', 
                                                     user_phone='".$this->user_phone."', user_office='".$this->user_office."', 
                                                     user_password='".$this->user_password."', user_password_md5='".md5($this->user_password)."', user_country='".$office['of_country']."', user_city='".$office['of_city']."',
                                                     user_office_phone='".$office['of_phone']."'
                              WHERE user_id='".$id."';");
        }
         
        $sql ->execute();           
     }
    
     //удаление сотрудника 
     public function user_delete_worker($id)
     {
        $dbo = $this->dbo();  
        $sql = $dbo->prepare("DELETE FROM  `crm_users` WHERE user_id='".$id."' and user_id <> ".$_SESSION['user_id'].";");
       
        $sql ->execute();
  
     }
     
    
     //регулярка (профиль)
     public function user_required_profile()
     {  
        $database = new database;  
        $array_users= $database->db_get_user();
        foreach($array_users as $user)
        {
            if($this->user_email === $user['user_email'] and $_SESSION['user_id'] !== $user['user_id'] )
            {
                $this->errors['user_email'] = 'Такой email уже используется.';
                return $this->errors;
            }
        }
         
        if($this->user_email === '')
        {
            $this->errors['user_email'] = 'Это поле обязательно для заполнения.';
        }
        
        if(empty($this->errors))     //если нет ошибок
        {
            $this->user_update_profile();
        }
        else                         
        {
            return $this->errors;
        }
         
     }
     
     //обновление профиля
     private function user_update_profile()
     {  
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_users` SET user_name='".$this->user_name."', user_lastname='".$this->user_lastname."', 
                                                     user_birthday='".$this->user_birthday."', user_post='".$this->user_post."', 
                                                     user_email='".$this->user_email."', user_phone='".$this->user_phone."' 
                              WHERE user_id='".$_SESSION['user_id']."';");
      
        $sql ->execute();
        
     }
      
     //регулярка (смена пароля)
     public function user_required_password()
     {
        $dbo = $this->dbo();
        $sql = $dbo->query('SELECT user_password FROM `crm_users` where user_id="'.$_SESSION['user_id'].'";');
        $array_password = $sql->fetchAll();
        
        foreach($array_password as $pas)
        {
            $password = $pas['user_password'];
        }
         
        if($this->user_password === '')
        {
            $this->errors['user_password'] = "Введите пароль";
        }
        elseif($this->user_password !==  $password )
        {
            $this->errors['user_password'] = "Неверный пароль";
        }
        
        if($this->user_new_password_one !== $this->user_new_password)
        {
            $this->errors['user_new_password']     = "Пароли не совпадают";
            $this->errors['user_new_password_one'] = "Пароли не совпадают";
        }
        
        if($this->user_new_password === '')
        {
            $this->errors['user_new_password'] = "Введите новый пароль";
        }
        elseif(mb_strlen($this->user_new_password,'UTF-8') < 5)
        {
            $this->errors['user_new_password'] = "Пароль должен состоять минимум из 5 символов";
        }
        
        if($this->user_new_password_one === '')
        {
            $this->errors['user_new_password_one'] = "Повторите пароль";
        }
        elseif(mb_strlen($this->user_new_password_one,'UTF-8') < 5)
        {
            $this->errors['user_new_password_one'] = "Пароль должен состоять минимум из 5 символов";
        }
         
        if(empty($this->errors))
        {
            $this->user_update_password();
        }
        else
        {
            return $this->errors;   
        }
     }
     
     //обновление пароля
     private function user_update_password()
     {
         $dbo = $this->dbo();
         $sql = $dbo->prepare("UPDATE `crm_users` SET 
                                        user_password='".$this->user_new_password."', 
                                        user_password_md5='".md5($this->user_new_password)."'
                               WHERE user_id='".$_SESSION['user_id']."';");
         $sql->execute();
     }
    
     //загрузка аватарки на сайт с проверкой 
     public function user_required_avatar($user_files)
     {
         if($user_files["user_avatar"]["size"] > 1024*3*1024)
         {
             $this->errors['user_avatar']="Размер файла превышает три мегабайта";
             return $this->errors;
         }
         
         if(($user_files["user_avatar"]["type"] !== "image/jpeg") and ($user_files["user_avatar"]["type"] !== "image/png") )
         {  
             $this->errors["user_avatar"]="Загрузите изображение в формате png или jpeg!";
             return $this->errors;
         }
         
         list($width, $height) = getimagesize( $user_files["user_avatar"]["tmp_name"] );
        
         if(($width !== 200) and ($height !== 200) )
         {
            $this->errors["user_avatar"]="Изображение должно иметь размер 200x200 !";
         }
        
         if(empty($this->errors['user_avatar']))
         {
             // Проверяем загружен ли файл
             if(is_uploaded_file($user_files['user_avatar']["tmp_name"]))
             {
                // Если файл загружен успешно, перемещаем его
                // из временной директории в конечную
                $filename = $_SESSION['user_id'] . rand().$user_files['user_avatar']["name"];
              
                move_uploaded_file($user_files['user_avatar']["tmp_name"], "views/avatar/".$filename);
                
                $dbo = $this->dbo();
                $sql = $dbo->prepare("UPDATE `crm_users` SET user_avatar='". $filename."' where user_id='".$_SESSION['user_id']."';");
                $sql->execute();
             } 
             else 
             {
                $this->errors['user_avatar']="Ошибка загрузки файла";
             }
         }
         
         if(isset($this->errors))
         {
            return $this->errors;
         }
     }
}
//-----------------------crm_update(Добавление изменений контрагента или контакта в БД)------------------------------------------------------------------
class crm_update extends database_config
{
    //Записываю все изменения (добавление, обновление) в таблицу crm_update
    protected function crm_update_contragent($id,$comment)
    {
        $database = new database;
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_updates` 
                                        (`update_user_name`, `update_user_lastname`, `update_datetime`, `update_comment`,`contragent_id`) 
                              VALUES
                                        ('".$database->db_get_user_name($_SESSION['user_id'])."', '".$database->db_get_user_lastname($_SESSION['user_id'])."', '".date("Y-m-d H:i:s")."', '".$comment."','".$id."')");
        $sql ->execute();
    }
    
    //Записываю все изменения (добавление, обновление) в таблицу crm_update
    protected function crm_update_contact($id,$comment)
    {
        $database = new database;
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_updates` 
                                        (`update_user_name`, `update_user_lastname`, `update_datetime`, `update_comment`,`contact_id`) 
                              VALUES
                                        ('".$database->db_get_user_name($_SESSION['user_id'])."', '".$database->db_get_user_lastname($_SESSION['user_id'])."', '".date("Y-m-d H:i:s")."', '".$comment."','".$id."')");
        $sql ->execute();
    }
}
//-----------------------crm_contact(работа с контактами)------------------------------------------------------------------
class crm_contact extends crm_update
{
    public  $cont_name;                    //наименование
    public  $cont_lastname;                //наименование
    public  $cont_contragent;              //контрагент
    public  $cont_phone;                   //телефон
    public  $cont_email;                   //почта
    public  $cont_status;                  //статус
    public  $cont_post;                    //должность
    public  $cont_skype;                   //скайп
    public  $cont_author;                  //автор
    
    protected $errors = [];                //массив с ошибками
    
    //конструктор принемающий входные данные 
    public function __construct($cont_post = null) 
    {
        if ($cont_post !== null && is_array($cont_post))
        {   
            $this->cont_name  	   = trim(array_get($cont_post, 'cont_name')); 
            $this->cont_lastname   = trim(array_get($cont_post, 'cont_lastname'));
            $this->cont_contragent = trim(array_get($cont_post, 'cont_contragent'));            
            $this->cont_phone      = trim(array_get($cont_post, 'cont_phone'));            
            $this->cont_email      = trim(array_get($cont_post, 'cont_email'));          
            $this->cont_status     = trim(array_get($cont_post, 'cont_status'));     
            $this->cont_post	   = trim(array_get($cont_post, 'cont_post'));          
            $this->cont_skype	   = trim(array_get($cont_post, 'cont_skype'));         
            $this->cont_author     = $_SESSION['user_id'];               
        }
    }
    
    //включение дополнительных полей 
    public function cont_table($POST)
    {
        array_get_cont_session($POST, 'name'); 
        array_get_cont_session($POST, 'contragent');
        array_get_cont_session($POST, 'phone');
        array_get_cont_session($POST, 'email');
        array_get_cont_session($POST, 'status');
        array_get_cont_session($POST, 'post');
        array_get_cont_session($POST, 'author');
        array_get_cont_session($POST, 'task');
        array_get_cont_session($POST, 'skype');
    }
    
    //регулярка (добовление контакта)
    public function cont_required_contact()
    {
        if(empty($this->errors))
        {
            $this->cont_add_contact();
        }
        else
        {
            return $this->errors;   
        }   
    }
    
    //добовление нового контакта
    private function cont_add_contact()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_contacts` 
                                        (`cont_contragent`, `cont_phone`, `cont_email`, `cont_status`, `cont_post`, `cont_skype`, `cont_author`,`cont_fullname`,`cont_office_id`) 
                              VALUES
                                        ('".$this->cont_contragent."', '".$this->cont_phone."', '".$this->cont_email."', '".'Новый'."', '".$this->cont_post."', '".$this->cont_skype."', '".$this->cont_author."', '".$this->cont_name.' '.$this->cont_lastname."','".$_SESSION['user_office']."')");

        $sql ->execute();
    }
    
    //изменение имени и фамилии контакта
    public function cont_update_name($id,$name)
    {
      
        if($contragent !== " ")
        {
            $database = new database;
            $comment = 'Изменил имя контакта на "'.$name.'"';
        
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contacts` SET `cont_fullname` = '".$name."' where cont_id='".$id."';");
      
            $sql ->execute();
            $this->crm_update_contact($id,$comment);
        }
    }
    
    //изменение компании
    public function cont_update_company($id,$contragent)
    {
          
        if($contragent !== " ")
        {
            $database = new database;
            $comment = 'Изменил компанию на "'.$database->db_get_contragentname($contragent).'"';
        
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contacts` SET `cont_contragent` = '".$contragent."' where cont_id='".$id."';");
      
            $sql ->execute();
            $this->crm_update_contact($id,$comment);
        }
    }
    
    
    
    //изменение должности
    public function cont_update_post($id,$post)
    {
        if($post !== " ")
        {
            $database = new database;
            $comment = 'Изменил должность на "'.$database ->db_get_postname($post).'"';
        
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contacts` SET `cont_post` = '".$post."' where cont_id='".$id."';");
      
            $sql ->execute();
        
            $this->crm_update_contact($id,$comment);
        }
    }
    
    public function cont_update_email($id,$email)
    {
        if($email !== '')
        {
            $database = new database;
            $comment = 'Изменил E-mail на "'.$email.'"';
        
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contacts` SET `cont_email` = '".$email."' where cont_id='".$id."';");
      
            $sql ->execute();
        
            $this->crm_update_contact($id,$comment);
        }
    }
    
    public function cont_update_email_2($id,$email)
    {
        if($email !== '')
        {
            $database = new database;
            $comment = 'Изменил второй E-mail на "'.$email.'"';
        
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contacts` SET `cont_email_2` = '".$email."' where cont_id='".$id."';");
      
            $sql ->execute();
        
            $this->crm_update_contact($id,$comment);
        }
    }
    
    public function cont_update_phone($id,$phone)
    {
        if($phone !== '')
        {
            $database = new database;
            $comment = 'Изменил телефон на "'.$phone.'"';
        
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contacts` SET `cont_phone` = '".$phone."' where cont_id='".$id."';");
            $sql ->execute();
        
            $this->crm_update_contact($id,$comment);
        }
    }
    
    public function cont_update_phone_2($id,$phone)
    {
        if($phone !== '')
        {
            $database = new database;
            $comment = 'Изменил второй телефон на "'.$phone.'"';
        
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contacts` SET `cont_phone_2` = '".$phone."' where cont_id='".$id."';");
            $sql ->execute();
        
            $this->crm_update_contact($id,$comment);
        }
    }
    
    public function cont_update_comment($id,$comment)
    {
        if($comment !== '')
        {
            $database = new database;
            $comment_update = 'Изменил описание на "'.$comment.'"';
        
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contacts` SET `cont_comment` = '".$comment."' where cont_id='".$id."';");
            $sql ->execute();
        
            $this->crm_update_contact($id,$comment_update);
        }
    }
}

//добавление и изменение контрагента
class crm_contragent extends crm_update
{
    public  $contr_name;                    //наименование
   
    public  $contr_email;                   //почта
    public  $contr_phone;                   //телефон
    public  $contr_user_id;                 //ответственное лицо 
    public  $contr_category;                //категория
    public  $contr_date_creation;           //дата создания
    public  $contr_status;                  //статус
    public  $contr_type;                    //тип (Истец Ответчик Агент)
    public  $contr_author;                  // автор
    public  $contr_comment;                 //описание
    public  $contr_stage;
    
    public  $task_name;                  
    public  $task_date;                
    public  $task_time;
    public  $task_comment;
    
    protected $errors = [];                 //массив с ошибками
    
    //конструктор принемающий входные данные 
    public function __construct($post = null) 
    {
        if ($post !== null && is_array($post))
        {   
            $this->contr_stage  		 = trim(array_get($post, 'contr_stage')); 
            
            
            $this->contr_name  		     = trim(array_get($post, 'contr_name'));         
                        
            $this->contr_email           = trim(array_get($post, 'contr_email'));            
            $this->contr_phone           = trim(array_get($post, 'contr_phone'));          
            $this->contr_user_id         = trim(array_get($post, 'contr_user_id'));     
            $this->contr_category	     = trim(array_get($post, 'contr_category'));                  
            $this->contr_date_creation   = date("Y-m-d H:i:s");          
            $this->contr_status          = trim(array_get($post, 'contr_status'));             
            $this->contr_type 		     = trim(array_get($post, 'contr_type'));             
            $this->contr_author          = trim(array_get($post, 'contr_author'));         
            $this->contr_comment         = trim(array_get($post, 'contr_comment'));
            
            $this->task_name          = trim(array_get($post, 'task_name'));             
            $this->task_date 		     = trim(array_get($post, 'task_date'));             
            $this->task_time          = trim(array_get($post, 'task_time'));         
            $this->task_comment         = trim(array_get($post, 'task_comment')); 
        }
    }
    
    //включение дополнительных полей 
    public function contr_table($POST)
    {
        array_get_contr_session($POST, 'id'); 
        array_get_contr_session($POST, 'name');
        array_get_contr_session($POST, 'contact');
        array_get_contr_session($POST, 'phone');
        array_get_contr_session($POST, 'email');
        array_get_contr_session($POST, 'otvet');
        array_get_contr_session($POST, 'categor');
        array_get_contr_session($POST, 'date');
        array_get_contr_session($POST, 'status');
        array_get_contr_session($POST, 'type');
        array_get_contr_session($POST, 'avtor');
        array_get_contr_session($POST, 'task');
    }
    
    //регулярка (добовление контрагента)
    public function contr_required_contragent()
    {
            $this->contr_add_contragent();
            return $this->errors;
    }
    
    //добовление нового контрагента
    private function contr_add_contragent()
    {
      
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_contragents` 
                                        (`contr_name`,  `contr_email`, `contr_phone`, `contr_user_id`, `contr_category`,  `contr_date_creation`, `contr_status`, `contr_type`, `contr_author`,  `contr_comment`,`business_stage_id`,`contr_office_id`) 
                              VALUES
                                        ('".$this->contr_name."', '".$this->contr_email."', '".$this->contr_phone."', '".$_SESSION['user_id']."', '".$this->contr_category."', '".$this->contr_date_creation ."', '".$this->contr_status."', '".$this->contr_type."', '".$_SESSION['user_id']."','".$this->contr_comment."','".$this->contr_stage."','".$_SESSION['user_office']."')");
      
        $sql ->execute();
        
        
        if($this->task_time !== "" and $this->task_comment !== "")
        {
               $database = new database;
               $contr_id = $database->db_get_id();  //получаю id контрагента
        
      
               $sql2 = $dbo->prepare("INSERT INTO `crm_tasks` 
                                                (`task_name`, `task_date`,`task_time`,  `task_contragent_id`,`task_comment`,`task_author`,`task_office_id`,`task_datetime`) 
                                      VALUES
                                                ('".$this->task_name."', '".date_format(date_create($this->task_date),'Y-m-d')."', '".$this->task_time."', '".$contr_id."', '".$this->task_comment."','".$_SESSION['user_id']."','".$_SESSION['user_office']."','".date_format(date_create($this->task_date),'Y-m-d')." ".$this->task_time."')");
        
       
               $sql2 ->execute();  
        }
       
     
        
        
        
        header("location: ?location=kontragent");
    }
    
    //изменение имени контрагента
    public function name_update($id,$name)
    {
        if($name !== "")
        {
            $comment = 'Изменил имя контрагента на "'.$name.'"';
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `contr_name` = '".$name."' where contr_id='".$id."';");

            $sql ->execute();
            $this->crm_update_contragent($id,$comment);
        }
        
        header("location: ?location=kontragent_one&id=".$id);
    }
    
    public function stage_update($id,$stage)
    {
        
        
        
        if($stage !== " ")
        {
            $database = new database;
            $comment = 'Изменил стадию дела на "'.$database ->db_get_stage_name($stage).'"';
        
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `business_stage_id` = '".$stage."' where contr_id='".$id."';");

            $sql ->execute();
            $this->crm_update_contragent($id,$comment);
        }
        
        header("location: ?location=kontragent_one&id=".$id);
        
    }
    
    //изменение статуса
    public function status_update($id,$status)
    {
        if($status !== " ")
        {
            $comment = 'Изменил статус на "'.$status.'"';
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `contr_status` = '".$status."' where contr_id='".$id."';");

            $sql ->execute();
            $this->crm_update_contragent($id,$comment);
        }
        
        header("location: ?location=kontragent_one&id=".$id);
    }
    
    //изменение категории
    public function category_update($id,$category)
    {
        if($category !== " ")
        {
          
            $database = new database;
            $comment = 'Изменил категорию на "'.$database ->db_get_categorname($category).'"';
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `contr_category` = '".$category."' where contr_id='".$id."';");
      
            $sql ->execute();
            $this->crm_update_contragent($id,$comment);
        }
        
        header("location: ?location=kontragent_one&id=".$id);
    }
    
    //изменение типа контрагента
    public function type_update($id,$type)
    {
        if($type !== " ")
        {
            $comment = 'Изменил тип контрагента на "'.$type.'"';
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `contr_type` = '".$type."' where contr_id='".$id."';");

            $sql ->execute();
            $this->crm_update_contragent($id,$comment);
        }
        header("location: ?location=kontragent_one&id=".$id);
    }
    
    //изменение ответственного лица
    public function responsible_update($id,$responsible)
    {
        if($responsible !== " ")
        {
            $database = new database;

            $comment = 'Изменил ответственного на "'.$database->db_get_username($responsible).'"';
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `contr_user_id` = '".$responsible."' where contr_id='".$id."';");

            $sql ->execute();
            $this->crm_update_contragent($id,$comment);
        }
        header("location: ?location=kontragent_one&id=".$id); 
    }
    
    //изменение телефона
    public function phone_update($id,$phone)
    {
        if($phone !== "")
        {
            $comment = 'Изменил телефон на "'.$phone.'"';
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `contr_phone` = '".$phone."' where contr_id='".$id."';");

            $sql ->execute();
            $this->crm_update_contragent($id,$comment);
            header("location: ?location=kontragent_one&id=".$id); 
        }
    }
    
    //изменение телефона
    public function phone_update_2($id,$phone)
    {
        if($phone !== "")
        {
            $comment = 'Изменил второй телефон на "'.$phone.'"';
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `contr_phone_2` = '".$phone."' where contr_id='".$id."';");

            $sql ->execute();
            $this->crm_update_contragent($id,$comment);
            header("location: ?location=kontragent_one&id=".$id); 
        }
    }
    
    //изменение почты
    public function email_update($id, $email)
    {
        if($email !== "")
        {
            $comment = 'Изменил email на "'.$email.'"';
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `contr_email` = '".$email."' where contr_id='".$id."';");

            $sql ->execute();
            $this->crm_update_contragent($id,$comment);
        }
        header("location: ?location=kontragent_one&id=".$id); 
    }
    
    //изменение почты
    public function email_update_2($id, $email)
    {
        if($email !== "")
        {
            $comment = 'Изменил второй email на "'.$email.'"';
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `contr_email_2` = '".$email."' where contr_id='".$id."';");

            $sql ->execute();
            $this->crm_update_contragent($id,$comment);
        }
        header("location: ?location=kontragent_one&id=".$id); 
    }
    
    //изменение комментария
    public function comment_update($id, $comment)
    {
        if($comment !== " ")
        {
            $comment_update = 'Изменил описание на "'.$comment.'"';
            $dbo = $this->dbo();
            $sql = $dbo->prepare("UPDATE `crm_contragents` SET `contr_comment` = '".$comment."' where contr_id='".$id."';");

            $sql ->execute();
            $this->crm_update_contragent($id,$comment_update);
        }
        header("location: ?location=kontragent_one&id=".$id); 
    }
    
     //загрузка файла на сайт с проверкой 
     public function file_upload($contr_file,$contragent_id)
     {
         
       
       $file=count($contr_file['uploadfile']['name']);
       for($i=0;$i< $file;$i++)
       { 
           
         // Проверяем загружен ли файл
         if(is_uploaded_file($contr_file['uploadfile']["tmp_name"][$i]))
         {
            // Если файл загружен успешно, перемещаем его
            // из временной директории в конечную
            $filename = $contr_file['uploadfile']["name"][$i];
            
            move_uploaded_file($contr_file['uploadfile']["tmp_name"][$i], "views/files/".$filename);
                
            $dbo = $this->dbo();
            $sql = $dbo->prepare("INSERT INTO `crm_files` (`file_name`,`file_contragent_id`) VALUES ('". $filename."','".$contragent_id."');");
            $sql->execute();
         } 
         else 
         {
            $this->errors['uploadfile']="Ошибка загрузки файла";
         }
           
    
          
       }
         
         
      
      
         
         if(empty($this->errors))
         {
            $comment = 'Загрузил новый докумен  "'.$filename.'"';
            header("Location: ?location=kontragent_one&id=".$contragent_id);
            $this->crm_update_contragent($id,$comment);
         }
         else
         {
            return $this->errors;
         }
     }
    
}

class crm_task extends crm_update
{
    public $task_name;
    public $task_date;
    public $task_time;
    public $task_contact_id;
    public $task_contragent_id;
    public $task_comment;
    
    protected $errors = [];                //массив с ошибками
    
    //конструктор принемающий входные данные 
    public function __construct($task_post = null) 
    {
        if ($task_post !== null && is_array($task_post))
        {   
            $this->task_name 	   = trim(array_get($task_post, 'task_name')); 
            $this->task_date 	   = trim(array_get($task_post, 'task_date')); 
            $this->task_time 	   = trim(array_get($task_post, 'task_time'));
            $this->task_contact_id = trim(array_get($task_post, 'task_contact_id')); 
            $this->task_contragent_id = trim(array_get($task_post, 'task_contragent_id')); 
            $this->task_comment  =  trim(array_get($task_post, 'task_comment'));
        }
    }
    
    public function task_required_task()
    {
        if($this->task_time == '')
        {
            $this->errors['task_time'] = 'Выберите время';
        }

        if($this->task_name == '')
        {
            $this->errors['task_name'] = 'Выберите задачу';
        }
        
        if($this->task_comment == '')
        {
            $this->errors['task_comment'] = 'Введите комментарий';
        }
        
        if(empty($this->errors))
        {
            $this->task_add_task();
        }
        else
        {
            return $this->errors;
        }
    }
    
    private function task_add_task()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_tasks` 
                                        (`task_name`, `task_date`,`task_time`, `task_contact_id`, `task_contragent_id`,`task_comment`,`task_author`,`task_office_id`,`task_datetime`) 
                              VALUES
                                        ('".$this->task_name."', '".date_format(date_create($this->task_date),'Y-m-d')."', '".$this->task_time."', '".$this->task_contact_id."', '".$this->task_contragent_id."', '".$this->task_comment."','".$_SESSION['user_id']."','".$_SESSION['user_office']."','".date_format(date_create($this->task_date),'Y-m-d')." ".$this->task_time."')");
        
       
        $sql ->execute();
    }
    

    
    public function task_delete($location,$id,$task_id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_tasks`SET task_name='Не выполнено' where task_id='".$task_id."';");
                                        

        $sql ->execute();
        header("location: ?location=".$location."&id=".$id."&flag=up");
    }
    
    public function task_success($location,$id,$task_id)
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_tasks` SET task_name='Выполнено', task_date ='".date('Y-m-j')."' where task_id='".$task_id."';");
                                        

        $sql ->execute();
        header("location: ?location=".$location."&id=".$id."&flag=up");
    }
    
    public function task_update($location,$id,$task_id)
    {
    
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_tasks` SET task_name='". $this->task_name."', task_date='".$this->task_date."',
                                                     task_time='".$this->task_time."', task_contact_id='". $this->task_contact_id."',
                                                     task_contragent_id='".$this->task_contragent_id."', task_comment='".$this->task_comment."', task_datetime='".$this->task_date." ".$this->task_time."'
                                                     where task_id='".$task_id."';");
                                        

        $sql ->execute();
        header("location: ?location=".$location."&id=".$id."&flag=up");
    }
    
    
}



//задачи
class crm_note extends database_config
{
    public $not_user_id;
    public $not_datetime;
    public $not_comment;
    public $not_contact_id;
    public $not_contragent_id;
    
    protected $errors = [];                //массив с ошибками
    
    //конструктор принемающий входные данные 
    public function __construct($not_post = null) 
    {
        if ($not_post !== null && is_array($not_post))
        {   
            $database = new database;
            $this->not_user_id 	     = $_SESSION['user_id'];
            $this->not_datetime      = date("Y-m-d H:i:s");
            $this->not_comment       = trim(array_get($not_post, 'not_comment')); 
            $this->not_contact_id    = trim(array_get($not_post, 'not_contact_id')); 
            $this->not_contragent_id = trim(array_get($not_post, 'not_contragent_id')); 
        }
    }
    
    
    public function not_add_note($location,$id)
    {
       if($this->not_comment !== '')
       {
            $dbo = $this->dbo();
            $sql = $dbo->prepare("INSERT INTO `crm_notes` 
                                        (`not_user_id`, `not_datetime`, `not_comment`,`not_contact_id`,`not_contragent_id`) 
                              VALUES
                                        ('".$this->not_user_id."',  '".$this->not_datetime."', '".$this->not_comment."', '".$this->not_contact_id."', '".$this->not_contragent_id."')");
       

            $sql ->execute();
       }
        
       header("location: ?location=".$location."&id=".$id);
    }
    
}

//Реквизиты
class crm_requisites extends database_config
{
    public $req_name;
    public $req_inn;
    public $req_yur_adress;
    public $req_actual_adress;
    public $req_kpp;
    public $req_ogrn;
    public $req_okpo;
    public $req_bik;
    public $req_score;
    public $req_kor_score;
    public $req_pod_face;
    public $req_base;
    
    protected $errors = [];                //массив с ошибками
    
    //конструктор принемающий входные данные 
    public function __construct($req_post = null) 
    {
        if ($req_post !== null && is_array($req_post))
        {   
            $this->req_name 	     = trim(array_get($req_post, 'req_name'));
            $this->req_inn           = trim(array_get($req_post, 'req_inn'));
            $this->req_yur_adress    = trim(array_get($req_post, 'req_yur_adress'));
            $this->req_actual_adress = trim(array_get($req_post, 'req_actual_adress')); 
            $this->req_kpp           = trim(array_get($req_post, 'req_kpp'));; 
            $this->req_ogrn          = trim(array_get($req_post, 'req_ogrn')); 
            $this->req_okpo 	     = trim(array_get($req_post, 'req_okpo'));
            $this->req_bik           = trim(array_get($req_post, 'req_bik'));  
            $this->req_score         = trim(array_get($req_post, 'req_score'));
            $this->req_kor_score     = trim(array_get($req_post, 'req_kor_score'));
            $this->req_pod_face      = trim(array_get($req_post, 'req_pod_face')); 
            $this->req_base          = trim(array_get($req_post, 'req_base')); 
           
        }
    }
    
    public function req_add_requisites($contragent_id) 
    {
        $dbo = $this->dbo();
        $database = new database;
        $array_requisites = $database->db_get_requisites();
  
        foreach($array_requisites as $requisite )
        {
            if($contragent_id === $requisite['req_contragent_id'])
            {
                $flag = true;
            }
        }
        
        if($flag === true)
        {
            $sql = $dbo->prepare("UPDATE `crm_requisites` SET 
                                            `req_name`='".$this->req_name ."', `req_inn`='". $this->req_inn."',`req_yur_adress`='".$this->req_yur_adress."', `req_actual_adress`='".$this->req_actual_adress."',`req_kpp`='".$this->req_kpp."',`req_ogrn`='".$this->req_ogrn."',`req_okpo`='".$this->req_okpo."',`req_bik`='".$this->req_bik."',`req_score`='".$this->req_score."',`req_pod_face`='".$this->req_pod_face."',`req_base`='".$this->req_base."',`req_kor_score`='".$this->req_kor_score."' where req_contragent_id='".$contragent_id."';");
            
            $sql ->execute();
                                 
        }
        else
        {
            $sql = $dbo->prepare("INSERT INTO `crm_requisites` 
                                            (`req_name`, `req_inn`,`req_yur_adress`, `req_actual_adress`,`req_kpp`,`req_ogrn`,`req_okpo`,`req_bik`,`req_score`,`req_pod_face`,`req_base`,`req_contragent_id`,`req_kor_score`) 
                                  VALUES
                                            ('".$this->req_name ."', '". $this->req_inn."', '".$this->req_yur_adress."', '".$this->req_actual_adress."', '".$this->req_kpp."', '".$this->req_ogrn."', '".$this->req_okpo."', '".$this->req_bik."', '".$this->req_score."', '".$this->req_pod_face."', '".$this->req_base."', '".$contragent_id."', '".$this->req_kor_score."')");
            $sql ->execute();
        }
        
        
       
    }
}
