 <div class="modal fade modal-dialog-center " id="myModal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog ">
       <div class="modal-content-wrap">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                   <h4 class="modal-title">Новый сотрудник</h4>
               </div>                                                    
                 <form action="index.php?action=user_add_worker" method="post">
             
                    <div class="modal-body">
                      <input type="text"  name = "user_name" class="form-control" placeholder="Имя">
                      <br/>
                      <input type="text"  name = "user_lastname" class="form-control" placeholder="Фамилия">
                      <br/>
                      <input type="text"  name = "user_post" class="form-control" placeholder="Должность">
                      <br/>
                      <span style="color:#F67A6E" title="Для добавления сотрудника, нужно добавить офис из списка, если список пустой создайте офис."><?=  empty($error['user_office'])? '' : $error['user_office'] ?></span>
                      <select name = "user_office" class="form-control">
                          <?php //вывод офисов
                             $database = new database;
                             $array_offices = $database->db_get_office();

                             foreach($array_offices as $office)
                             {
                                 print'<option value="'.$office['of_id'].'">'.$office['of_name'].'</option>';
                             }

                          ?>
                      </select>
                      <br/>
                      <strong style="color:#F67A6E"><?=  empty($error['user_email'])? '' : $error['user_email'] ?></strong>
                      <input type="email"  name = "user_email" class="form-control" placeholder="E-mail" >
                      <br/>
                      <strong style="color:#F67A6E"><?=  empty($error['user_password'])? '' : $error['user_password'] ?></strong>
                      <input type="password"  name = "user_password" class="form-control" placeholder="Пароль" pattern="[A-Za-z0-9]{5,}">
                      <br/>
                      <input type="hidden"  name = "user_type" value="3">
                      <input type="tel"  name = "user_phone" class="form-control" placeholder="Мобильный телефон" pattern="[0-9]{11}">
                      <br/>                                                  
                    </div>

                    <div class="modal-footer">
                       <input type="submit" class="btn btn-warning"  value="Добавить">
                    </div>
                  </form>
             </div>
       </div>
   </div>
</div>