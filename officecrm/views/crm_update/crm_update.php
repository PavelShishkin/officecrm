<div class="panel">
     <div class="panel-heading">
         Изменения 
         <span class="tools pull-right">
           <a href="javascript:;" class="fa fa-chevron-down"></a>
        </span>
     </div>
    
     <div class="panel-body" style="display:none"> 
       <div style="margin-left:12px;margin-left:12px;">
           <div class="room-box" style="overflow-x: scroll;height: 450px;">
                <?php 
                    
                     
                     
                     $database = new database;
                        
                     if($location === "kontragent_one")
                     {
                        $array_updates=$database -> db_get_update_contragent($_GET['id']);
                        foreach(array_reverse($array_updates) as $update)
                        {
                            print'
                                <p>'.$update['update_comment'].'</p>
                                <p><span class="text-muted">Автор :</span>'.$update['update_user_name'].' '.$update['update_user_lastname'].' | <span class="text-muted">Дата :</span>'.$update['update_datetime'].'</p>
                              <hr><br>';
                        }
                     }
                     elseif($location === "contact_one")
                     {
                        $array_updates=$database -> db_get_update_contact($_GET['id']);

                        foreach(array_reverse($array_updates) as $update)
                        {
                            print'
                                <p>'.$update['update_comment'].'</p>
                                <p><span class="text-muted">Автор :</span>'.$update['update_user_name'].' '.$update['update_user_lastname'].' | <span class="text-muted">Дата :</span>'.$update['update_datetime'].'</p>
                              <hr><br>';
                        }
                     }
                          
                     
                     
                ?>
            </div>
       </div> 
     </div>
</div>