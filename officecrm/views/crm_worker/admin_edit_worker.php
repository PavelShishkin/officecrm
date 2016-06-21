<div class="modal fade modal-dialog-center " id="myModal_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content-wrap">
       <div class="modal-content">
           
         <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             <h4 class="modal-title">Изменение сотрудника</h4>
         </div>         
          
         <form action="?action=user_edit_worker"  method="post"  >
           
           <div class="modal-body">
             <?php
                 $database = new database;
                 if(isset($_POST['user_id']))
                 {
                    $array_user= $database->db_get_user_id($_POST['user_id']);
                    foreach($array_user as $user)
                    {?>
                         <input type="hidden"  name = "user_id"  value="<?= $_POST['user_id'] ?>" >
                         <input type="text"  name = "user_name" class="form-control" value="<?= $user['user_name'] ?>" placeholder="Имя">
                         <br/>
                         <input type="text"  name = "user_lastname" class="form-control" value="<?= $user['user_lastname'] ?>" placeholder="Фамилия">
                         <br/>
                         <input type="text"  name = "user_post" class="form-control" value="<?= $user['user_post'] ?>" placeholder="Должность">
                         <br/>
                         <span style="color:#F67A6E" title="Для добавления сотрудника, нужно добавить офис из списка, если список пустой создайте офис."><?=  empty($error['user_office'])? '' : $error['user_office'] ?></span>
                         <select name = "user_office" class="form-control">
                         <?= //вывод офисов

                            $array_offices = $database->db_get_office();

                            foreach($array_offices as $office)
                            {
                                if($office['of_id'] ===  $user['user_office'])
                                {
                                    print'<option selected value="'.$office['of_id'].'">'.$office['of_name'].'</option>';
                                }
                                else
                                {
                                    print'<option value="'.$office['of_id'].'">'.$office['of_name'].'</option>';
                                }
                            }

                         ?>
                         </select>
                         <br/>
                         <strong style="color:#F67A6E"><?=  empty($error['user_email'])? '' : $error['user_email'] ?></strong>
                         <input type="email"  name = "user_email" class="form-control" value="<?= $user['user_email'] ?>"  placeholder="E-mail" >
                         <br/>
                         <strong style="color:#F67A6E"><?=  empty($error['user_password'])? '' : $error['user_password'] ?></strong>
                         <input type="password"  name = "user_password" class="form-control" value="<?= $user['user_password'] ?>" placeholder="Пароль" pattern="[A-Za-z0-9]{5,}">
                         <br/>
                         <input type="tel"  name = "user_phone" class="form-control" value="<?= $user['user_phone'] ?>" placeholder="Мобильный телефон" pattern="[0-9]{11}">
                         <br/>
                       </div>
                <?}
                 }?>
           <div class="modal-footer">
              <input type="submit" class="btn btn-warning"  value="Изменить">
           </div>
             
         </form>
        </div>
      </div>
    </div>
</div>