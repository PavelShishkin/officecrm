  
<?php
    $database = new database;
    if($location === 'kontragent_one')
    {
        $array_tasks = $database->db_get_task();
                                         
        foreach($array_tasks as $task)
        {   
            
            $author = $database->db_get_username($task['task_author']);
           
            if($author === "")
            {
                $author = 'Сотрудник был удален';
            }
            
            
            if($task['task_contragent_id'] === $_GET['id'])
            {
              if($task['task_name'] == "Встреча"){$external = 'external-event label label-primary ui-draggable';}
              elseif($task['task_name'] == "Звонок"){$external = 'external-event label label-success ui-draggable';}
              elseif($task['task_name'] == "Дело"){$external = 'external-event label label-info ui-draggable';}
              elseif($task['task_name'] == "Совещание"){$external = 'external-event label label-inverse ui-draggable';}
              elseif($task['task_name'] == "Вх звонок"){$external = 'external-event label label-warning ui-draggable';}
              elseif($task['task_name'] == "Исх звонок"){$external = 'external-event label label-danger ui-draggable';}
              elseif($task['task_name'] == "Личное"){$external = 'external-event label label-default ui-draggable';}
              elseif($task['task_name'] == "Корпоратив"){$external = 'external-event label label-primary ui-draggable';}
              elseif($task['task_name'] == "Письмо"){$external = 'external-event label label-info ui-draggable';}
              elseif($task['task_name'] == "Выполнено"){$external = 'external-event label label-success ui-draggable';}
              elseif($task['task_name'] == "Заседание"){$external = 'external-event label label-success ui-draggable';}
              elseif($task['task_name'] == "Не выполнено"){$external = 'external-event label label-danger ui-draggable';}
              else {$external = 'external-event label label-danger ui-draggable';}
                          
              print'<div class="timeline-messages">
                      <div class="msg-time-chat">
                        <a href="#" class="message-img">
                        <img class="avatar" src="views/avatar/'.$database->db_get_avatar_id($task['task_author']).'" alt=""></a>
                        <div class="message-body msg-in">
                            <div class="pull-right hidden-phone">
                            
                                <a class="btn btn-success btn-xs" href="?location=task_success&id='.$_GET['id'].'&task_id='.$task['task_id'].'&header=kontragent_one"  data-toggle="modal"><i class="fa fa-check"></i></a>
                                
                                <a  class="btn btn-primary btn-xs" href="?location=kontragent_one&id='.$_GET['id'].'&task_id='.$task['task_id'].'"><i class="fa fa-pencil" data-toggle="modal"></i></a>
                                
                                <a class="btn btn-danger btn-xs" href="?location=task_delete&id='.$_GET['id'].'&task_id='.$task['task_id'].'&header=kontragent_one"  data-toggle="modal"><i class="fa fa-trash-o"></i></a>
                            </div>
                            
                            <div  class="'.$external.'">'.$task['task_name'].'</div>
                                <div class="text" >
                    
                                <p class="attribution" ><a>'.$author.'</a>'.$task['task_date'].'  '.$task['task_time'].'</p>
                                
                                <p>'.$task['task_comment'].'</p>
                            </div>
                        </div>
                      </div>
                    </div>';                         
            }                             
        }
    }
    elseif($location === 'contact_one')
    {
        $array_tasks = $database->db_get_task();
        
                                 
        foreach($array_tasks as $task)
        {  
            $author = $database->db_get_username($task['task_author']);
           
            if($author === "")
            {
                $author = 'Сотрудник был удален';
            }
            
            if($task['task_contact_id'] === $_GET['id'])
            {
              if($task['task_name'] == "Встреча"){$external = 'external-event label label-primary ui-draggable';}
              elseif($task['task_name'] == "Звонок"){$external = 'external-event label label-success ui-draggable';}
              elseif($task['task_name'] == "Дело"){$external = 'external-event label label-info ui-draggable';}
              elseif($task['task_name'] == "Совещание"){$external = 'external-event label label-inverse ui-draggable';}
              elseif($task['task_name'] == "Вх звонок"){$external = 'external-event label label-warning ui-draggable';}
              elseif($task['task_name'] == "Исх звонок"){$external = 'external-event label label-danger ui-draggable';}
              elseif($task['task_name'] == "Личное"){$external = 'external-event label label-default ui-draggable';}
              elseif($task['task_name'] == "Корпоратив"){$external = 'external-event label label-primary ui-draggable';}
              elseif($task['task_name'] == "Письмо"){$external = 'external-event label label-info ui-draggable';}
              elseif($task['task_name'] == "Выполнено"){$external = 'external-event label label-success ui-draggable';}
              elseif($task['task_name'] == "Заседание"){$external = 'external-event label label-success ui-draggable';}
              elseif($task['task_name'] == "Не выполнено"){$external = 'external-event label label-danger ui-draggable';}
              else {$external = 'external-event label label-danger ui-draggable';}
                          
              print'<div class="timeline-messages">
                        <div class="msg-time-chat">
                        <a href="#" class="message-img">
                            <img class="avatar" src="views/avatar/'.$database->db_get_avatar_id($task['task_author']).'" alt=""></a>
                        </a>
                        <div class="message-body msg-in">
                            <div class="pull-right hidxden-phone">
                            
                                <a class="btn btn-success btn-xs" href="?location=task_success&id='.$_GET['id'].'&task_id='.$task['task_id'].'&header=contact_one"  data-toggle="modal"><i class="fa fa-check"></i></a>
                                
                                <a  class="btn btn-primary btn-xs" href="?location=contact_one&id='.$_GET['id'].'&task_id='.$task['task_id'].'&modal=on&flag=up"><i class="fa fa-pencil" data-toggle="modal"></i></a>
                                
                                <a class="btn btn-danger btn-xs" href="?location=task_delete&id='.$_GET['id'].'&task_id='.$task['task_id'].'&header=contact_one"  data-toggle="modal"><i class="fa fa-trash-o"></i></a>
                            </div>
                            
                            <div  class="'.$external.'">'.$task['task_name'].'</div>
                                <div class="text" >
                    
                                <p class="attribution" ><a>'.$author.'</a>'.$task['task_date'].'  '.$task['task_time'].'</p>
                                
                                <p>'.$task['task_comment'].'</p>
                            </div>
                        </div>
                      </div>
                    </div>';                         
            }                             
        }
    }
    ?>

                              
                 