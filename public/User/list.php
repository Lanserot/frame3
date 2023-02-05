@title=Список пользователей@
<div class="container mt-5 mb-5">
  <h3>Список доступных пользователей</h3>
<ul class="list-group">
  <?php foreach($users as $user){?>
    <a href="users/<?= $user['id']?>"><li class="list-group-item">Login : <?= $user['login']?></li></a>
  <?php }?>
</ul>
</div>
