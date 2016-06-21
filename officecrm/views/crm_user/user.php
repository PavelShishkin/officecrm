<!--header start-->
<header class="header white-bg">
   
        <table style="table-layout: fixed;">
            <tr>
              <td> 
                  <div class="sidebar-toggle-box">
                    <div class="fa fa-bars tooltips"></div>
                  </div>
              </td>
              <?php 
                $database = new database;
                $company_name   = $database->db_get_name_company();
                $company_image  = $database->db_get_image_company();
                $company_comment= $database->db_get_comment_company();
                $company_office = $database->db_get_office_company();
              ?>
              <td> 
                <a class="logo" >
                    <?= $company_name; ?>
                </a>
              </td>
              <td>
                <a class="logo" >
                    <span>
                    <?= $company_office; ?>
                    </span>
                </a>
              </td>
                
              <td>
                <img alt="" src="views/image_company/<?= $company_image ?>" width="45" height="45">
              </td>
              <td  width="80%" align="center">
                <div  style="overflow-x: scroll; height: 35px;" >
                    <strong style="font-size:22px; line-height:22px%;">
                     
                       <?php echo $company_comment ?></strong>
                </div>
             </td>
                
                
             <div class="top-nav ">
                <ul class="nav pull-right top-menu">
                  <?php 
                    $database = new database;
                    $array_user = $database->db_get_user_id($_SESSION['user_id']);
                 
                    foreach($array_user as $user)
                    {
                   ?>
                    
                   <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <img alt="" src="views/avatar/<?= $user['user_avatar'] ?> " width="55" height="50">
                          <span class="username"><?= $user['user_name'].' '.$user['user_lastname']?></span>
                          <b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu extended logout">
                          <div class="log-arrow-up"></div>
                          <li><a href="?location=contact"><i class=" fa fa-suitcase"></i>Контакты</a></li>
                          <li><a href="?location=profile"><i class="fa fa-cog"></i>Настройки</a></li>
                          <li><a href="#"><i class="fa fa-bell-o"></i>Задачи</a></li>
                          <li><a href="?location=exit"><i class="fa fa-key"></i> Выйти</a></li>
                      </ul>
                  </li>
                    
                  <?}?>
                
                </ul>
            </div>
          </tr>
       </table>
    
</header>