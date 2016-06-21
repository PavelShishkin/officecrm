 <section class="panel">
        
                          <div class="panel-body bio-graph-info">
                              <h1> Редактировать профиль</h1>
                              <form action='?action=user_update_profile' method="post" class="form-horizontal" >
                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Имя</label>
                                      <div class="col-lg-6">
                                          <input name="user_name" type="text" class="form-control" id="f-name" value="<?= empty($user['user_name'])?'':$user['user_name'] ?>">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Фамилия</label>
                                      <div class="col-lg-6">
                                          <input name="user_lastname"  type="text" class="form-control" id="l-name" value="<?= empty($user['user_lastname'])?'':$user['user_lastname'] ?>">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">День рождения</label>
                                      <div class="col-lg-6">
                                          <input name="user_birthday" type="date" class="form-control" id="b-day" value="<?= empty($user['user_birthday'])?'':$user['user_birthday'] ?>">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Должность</label>
                                      <div class="col-lg-6">
                                          <input name="user_post" type="text" class="form-control" id="occupation" value="<?= empty($user['user_post'])?'':$user['user_post'] ?>">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Email</label>
                                      <div class="col-lg-6">
                                          <input name="user_email" type="email" class="form-control" id="email" value="<?= empty($user['user_email'])?'':$user['user_email'] ?>">
                                      </div>
                                      <strong style="color:#F67A6E"><?=  empty($error['user_email'])? '' : $error['user_email'] ?></strong>
                                  </div>
                                  <div class="form-group">
                                      <label  class="col-lg-2 control-label">Моб. телефон</label>
                                      <div class="col-lg-6">
                                          <input name="user_phone" type="text" class="form-control" id="mobile" value="<?= empty($user['user_phone'])?'':$user['user_phone'] ?>">
                                      </div>
                                  </div>
                                   

                                  <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <button type="submit" class="btn btn-success">Сохранить</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
</section>