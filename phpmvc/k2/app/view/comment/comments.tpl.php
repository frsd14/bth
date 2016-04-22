<h2>Comments</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php
function test($param) {
  print('<div class="name">');
  print($param);
  print('</div>');
  }
  function test2($param) {
    print('<div class="content">');
    print($param);
    print('</div>');
  }
  function test3($param) {
    print('<div class="content">');
    print ("<p><label>Name:<br/><input type='text' name='content' value=$param /></label></p>");
    print('</div>');
  }
  function test4($param) {

    $paramArray = array('content'=>'test');

    foreach($param as $paramName => $paramValue)
    {
    print("<div class=$paramName>");
    print ("<p><label>$paramName<br/><input type='text' name='$paramName' value=$paramValue /></label></p>");
    print('</div>');
    }
  }

  function test5($param) {

    $paramArray = array('content'=>'test');

    foreach($param as $paramName => $paramValue)
    {
    print("<div class=$paramName>");
    if($paramName == 'content') {
      print ("<p><label>$paramName<br/><textarea name='$paramName'/>$paramValue</textarea></label></p>");
    }else {
      print ("<p><label>$paramName<br/><input type='text' name='$paramName' value=$paramValue /></label></p>");
    }
    print('</div>');
    }
  }
  function test6($param) {

    $paramArray = array('content'=>'test');

    foreach($param as $paramName => $paramValue)
    {
    print("<div class=$paramName>");
    print ("<p><label>$paramName$paramValue</label></p>");
    print('</div>');
    }
  }
?>



<?php foreach ($comments as $id => $comment) : ?>
<?php foreach ($comment as $key => $value) : ?>

<?php if ($key == "mail") : ?><?php $mail = $value; ?><?php endif; ?>
<?php if ($key == "id") : ?><?php $id = $value; ?><?php endif; ?>
<?php if ($key == "name") : ?><?php $name = array('name' => $value);?><?php endif; ?>
<?php if ($key == "content") : ?><?php $content = array('content' => $value);?><?php endif; ?>
<?php if ($key == "web") : ?><?php $web = $value; ?><?php endif; ?>
<?php if ($key == "ip") : ?><?php $ip = $value; ?><?php endif; ?>
<?php if ($key == "timestamp") : ?><?php $timestamp = $value; ?><?php endif; ?>
<?php if ($key == "edit") : ?><?php $setEdit = $value; ?><?php endif; ?>

<?php endforeach; ?>

<div class="comment">
  <?php print('<div class="gravatar">') ?>
  <?php if ($mail) : ?>
    <?php
    $size = 40;
    $email = $mail;
    $default = "http://www.gravatar.com/avatar/00000000000000000000000000000000";
    $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
    ?>
    <img src="<?php echo $grav_url; ?>" alt="" height="42" width="42" />

    <?php if (file_exists($grav_url)) :?>
      <img src="<?php echo $grav_url; ?>" alt="" />
    <?php endif; ?>
  <?php endif; ?>
  <?php print(date("Y-m-d H:i:s",$timestamp))?>

</div>


<?php if ($id) : ?>
  <?php print('<div class="removeBtn">') ?>
<form method=post>
  <?php if($router == "home") : ?>
    <input type=hidden name="redirect" value="<?=$this->url->create('')?>">
  <?php endif; ?>

  <?php if($router != "home") : ?>
    <input type=hidden name="redirect" value="<?=$this->url->create($router)?>">
  <?php endif; ?>

<?php
  $edit = "comment/edit/$router/$id";
  $save = "comment/save/$router/$id";
  $removeId = "comment/remove-one/$router/$id";
  $addResponse = "comment/addResponse/$router/$id";
?>

<?php if ($setEdit) : ?>
  <input type='submit' name='doSave' value='spara' onClick="this.form.action = '<?=$this->url->create($save)?>'"/>
  <input type='submit' name='doRemoveOne' value='Ta bort' onClick="this.form.action = '<?=$this->url->create($removeId)?>'"/>
<?php else : ?>
  <input type='submit' name='doBack' value='back' onClick="this.form.action = '<?=$this->url->create($back)?>'"/>
  <input type='submit' name='doEdit' value='edit' onClick="this.form.action = '<?=$this->url->create($edit)?>'"/>
  <input type='submit' name='doRemoveOne' value='Ta bort' onClick="this.form.action = '<?=$this->url->create($removeId)?>'"/>
<?php endif; ?>


<?php print(" <br /> ")?>
<?php print('</div>') ?>
<?php endif; ?>


<?php if ($content) : ?>

<?php
/*
function test($param) {
  print('<div class="name">');
  print($param);
  print('</div>');
  }
function test2($param) {
  print('<div class="content">');
  print($param);
  print('</div>');
}

*/

if($setEdit) {
  test5($content);
  test5($name);
} else {
  test6($content);
  test6($name);
}
?>

<?php endif; ?>
</form>

</div>
<?php endforeach; ?>

</div>
<?php endif; ?>
