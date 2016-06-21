<section class="panel" >
                          <header class="panel-heading">
                              Заметки
                              <span class="tools pull-right">
                                <a class="fa fa-chevron-up" href="javascript:;" ></a>
                                
                            </span>
                          </header>
                          <div class="panel-body">
                              <div style="overflow-x: scroll;height: 380px;" >
                                  <?php
                                  if(  !class_exists('database') ) {
                                     include ($_SERVER['DOCUMENT_ROOT']. "/officecrm/models/database.php");
                                  }
                                    $database = new database;
                                    if($_GET['location'] === 'kontragent_one')
                                    {
                                        $array_notes = $database -> db_get_note_contragent_id($_GET['id']);
                                        $array_users = $database -> db_get_user();
                                         
                                        foreach(array_reverse($array_notes) as $note)
                                        {
                                            foreach($array_users  as $user)
                                            {   
                                                if($user['user_id'] === $note['not_user_id'])
                                                {
                                                print'<div class="timeline-messages">
                                                        <div class="msg-time-chat">
                                                            <a href="#" class="message-img">
                                                                <img class="avatar" src="views/avatar/'.$user['user_avatar'].'" alt="">
                                                            </a>
                                                            <div class="message-body msg-in">
                                                                <span class="arrow"></span>
                                                                <div class="text">
                                                                    <p class="attribution"><a>'.$user['user_name'].' '.$user['user_lastname'].'</a>'.$note['not_datetime'].'</p>
                                                                    <p>'.$note['not_comment'].'</p>
                                                                </div>
                                                            </div>
                                                          </div>
                                                        </div>';
                                                }
                                                
                                            }
                                        }
                                    }
                                    elseif($_GET['location'] === 'contact_one')
                                    {
                                        $array_notes = $database -> db_get_note_contact_id($_GET['id']);
                                        $array_users = $database -> db_get_user();
                                         
                                        foreach(array_reverse($array_notes) as $note)
                                        {
                                            foreach($array_users  as $user)
                                            {
                                                if($user['user_id'] === $note['not_user_id'])
                                                {
                                                    
                                                
                                                print'<div class="timeline-messages">
                                                        <div class="msg-time-chat">
                                                            <a href="#" class="message-img">
                                                                <img class="avatar" src="views/avatar/'.$user['user_avatar'].'" alt="">
                                                            </a>
                                                            <div class="message-body msg-in">
                                                                <span class="arrow"></span>
                                                                <div class="text">
                                                                    <p class="attribution"><a>'.$user['user_name'].' '.$user['user_lastname'].'</a>'.$note['not_datetime'].'</p>
                                                                    <p>'.$note['not_comment'].'</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     </div>';
                                                }
                                            }
                                        }
                                    }
                             
                                    ?>
                                 
                              </div>
                              <div class="chat-form">
                                   <form action="?action=not_add_note&location=<?= $_GET['location']?>&id=<?= $_GET['id']?>" method="post">
                                    <?php 
                                       if($_GET['location'] === 'kontragent_one')
                                       {
                                           print'<input type="hidden" name="not_contragent_id" value="'.$_GET['id'].'">';
                                       }
                                       else
                                       {
                                           print'<input type="hidden" name="not_contact_id" value="'.$_GET['id'].'">';  
                                       }
                                       
                                       ?>
                                  <div class="input-cont ">
                                      <input name="not_comment" type="text" class="form-control col-lg-12" placeholder="Введите сообщение...">
                                  </div>
                                  <div class="form-group">
                                      <div class="pull-right chat-features">
                                          <button  onclick="show()" class="btn btn-danger" href="javascript:;">Отправить</button>
                                      </div>
                                      
                                  </div>
                                  </form>

                              </div>
                              </div>
                          
              </section>
                    
           