<?php 

//изменение логотипа компании логотипа и т.д
class crm_change extends database_config
{
    //шапка сайта
    public  $change_name_company;   //название компании
    public  $change_avatar;         //логотип компании
    public  $change_comment;        //комент в шапке сайта
    
    //таблица Статус
    public $status_id;   
    public $status_name;
    
    //таблица Сиадия дела
    public $stage_id;   
    public $stage_name;
    
   //таблица категории
    public $categor_id;   
    public $categor_name;
    
    //таблица Должности
    public $post_id;   
    public $post_name;
    
    //таблица тип контрагента
    public $contr_type_id;
    public $contr_type_name;
    
    
    
    
    public $errors = [];    //массив с ошибками 
    
    //проверка входных данных
    public function __construct($change_post = null)
    {
        if ($change_post !== null && is_array($change_post))
        {
            $this->change_name_company = trim(array_get($change_post, 'change_name_company'));          
            $this->change_avatar       = trim(array_get($change_post, 'change_avatar'));
            $this->change_comment      = trim(array_get($change_post, 'change_comment'));
            
            $this->status_id           = trim(array_get($change_post, 'status_id'));
            $this->status_name         = trim(array_get($change_post, 'status_name'));
            
            $this->stage_id           = trim(array_get($change_post, 'stage_id'));
            $this->stage_name         = trim(array_get($change_post, 'stage_name'));
            
            $this->categor_id           = trim(array_get($change_post, 'categor_id'));
            $this->categor_name         = trim(array_get($change_post, 'categor_name'));
            
            $this->post_id           = trim(array_get($change_post, 'post_id'));
            $this->post_name         = trim(array_get($change_post, 'post_name'));
            
            $this->contr_type_id           = trim(array_get($change_post, 'contr_type_id'));
            $this->contr_type_name         = trim(array_get($change_post, 'contr_type_name'));
        
        }
    }
    
    
    
    
    public function change_required_rename()
    {
        if($this->change_name_company == '')
        {
            $this->errors['change_name_company'] = 'Введите название компании';
        }
        
        if(empty($this->errors))
        {
            $this->change_rename();
        }
        else
        {
            return $this->errors;
        }
    }
    
    private function change_rename()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_company` SET company_name='".$this->change_name_company."';");
        $sql ->execute();
    }
    
    
    public function change_comment_update()
    {

        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_company` SET company_comment='".$this->change_comment."';");
        $sql ->execute();
    }
    
    //загрузка логотипа компании 
    public function change_update_avatar($file)
    {
     
         if($file["change_avatar"]["size"] > 1024*3*1024)
         {
             $this->errors['change_avatar']="Размер файла превышает три мегабайта!";
         }
         
         if(($file["change_avatar"]["type"] !== "image/jpeg") and ($file["change_avatar"]["type"] !== "image/png") )
         {  
            $this->errors['change_avatar']="Загрузите изображение в формате png или jpeg!";
         }
    
    
         if(empty($this->errors['change_avatar']))
         {
             // Проверяем загружен ли файл
             if(is_uploaded_file($file['change_avatar']["tmp_name"]))
             {
                // Если файл загружен успешно, перемещаем его
                // из временной директории в конечную
                $filename = $_SESSION['user_id'] . rand().$file['change_avatar']["name"];
              
                move_uploaded_file($file['change_avatar']["tmp_name"], "views/image_company/".$filename);
            
                $dbo = $this->dbo();
                $sql = $dbo->prepare("UPDATE `crm_company` SET company_image='". $filename."';");
                $sql->execute();
             } 
             else 
             {
                $this->errors['change_avatar']="Ошибка загрузки файла";
                return $this->errors;
             }
         }
         else
         {
             return $this->errors;
         }
         
    }
    
    public function status_update()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_status` SET status_name='".$this->status_name."' where status_id='".$this->status_id."';");
      
        $sql ->execute();
    }
    
    public function status_delete()
    {
       
        $dbo = $this->dbo();
        $sql = $dbo->prepare("DELETE FROM `crm_status` WHERE status_id='".$this->status_id."';");
    
        $sql ->execute();
    }
    
    public function status_add()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_status` (`status_name`) VALUES ('');");
    
        $sql ->execute();
    }
    
    
    public function stage_update()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_business_stage` SET stage_name='".$this->stage_name."' where stage_id='".$this->stage_id."';");
      
        $sql ->execute();
    }
    
    public function stage_delete()
    {
       
        $dbo = $this->dbo();
        $sql = $dbo->prepare("DELETE FROM `crm_business_stage` WHERE stage_id='".$this->stage_id."';");
    
        $sql ->execute();
    }
    
    public function stage_add()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_business_stage` (`stage_name`) VALUES ('');");
    
        $sql ->execute();
    }
    
    public function categor_update()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_categorys` SET categor_name='".$this->categor_name."' where categor_id='".$this->categor_id."';");
      
        $sql ->execute();
    }
    
    public function categor_delete()
    {
       
        $dbo = $this->dbo();
        $sql = $dbo->prepare("DELETE FROM `crm_categorys` WHERE categor_id='".$this->categor_id."';");
    
        $sql ->execute();
    }
    
    public function categor_add()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_categorys` (`categor_name`) VALUES ('');");
    
        $sql ->execute();
    }
    
    
    public function post_update()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_posts` SET post_name='".$this->post_name."' where post_id='".$this->post_id."';");
      
        $sql ->execute();
    }
    
    public function post_delete()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("DELETE FROM `crm_posts` WHERE post_id='".$this->post_id."';");
    
        $sql ->execute();
    }
    
    public function post_add()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_posts` (`post_name`) VALUES ('');");
    
        $sql ->execute();
    } 
    
    
     public function contr_type_update()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("UPDATE `crm_contr_type` SET type_name='".$this->contr_type_name."' where type_id='".$this->contr_type_id."';");
      
        $sql ->execute();
    }
    
    public function contr_type_delete()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("DELETE FROM `crm_contr_type` WHERE type_id='".$this->contr_type_id."';");
    
        $sql ->execute();
    }
    
    public function contr_type_add()
    {
        $dbo = $this->dbo();
        $sql = $dbo->prepare("INSERT INTO `crm_contr_type` (`type_name`) VALUES ('');");
    
        $sql ->execute();
    } 
}