<?php
require_once('co.php');
$t = new code;
$t->setName("Rolf");
print("boy biy");
print($t->getName());
?>

<h2>Comments</h2>
<?php print_r($comments);?>
<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php

$isArry = false;

function isArr($param){
  $isArry = $param;
}
function rArr(){
  return $isArry;
}


function testr($comments, $node) {

  $t = new code;

  //if(is_array($comments)) {
  foreach ($comments as $id => $comment) {
  //}
    $i=0;
  foreach ($comment as $key => $value) {

    //print(is_array($value));
    if(is_array($value)) {
      //print_r($value);
      isArr(true);
      testr(array($value),"child");
    } else {
      if($key == "name") {
        if($node =="child") {

      print('<style type="text/css">
      .comment12 {
        margin: 30px;
        padding: 30px;
        position: relative;
        width:350px;
        height:170px;
        border: solid 1px #555;
        background-color: #ddd;
        box-shadow: 0 0 10px rgba(0,0,0,0.6);
        -moz-box-shadow: 0 0 10px rgba(0,0,0,0.6);
        -webkit-box-shadow: 0 0 10px rgba(0,0,0,0.6);
        -o-box-shadow: 0 0 10px rgba(0,0,0,0.6);
        }
        </style>');
      print("<div class='comment12'>");
      print_r($value);

    //  print("</div>");
      print("<br />");
    }
    if($node =="parent") {
      print("<div class='comment'>");
      print_r($value);
    //  print("</div>");
    }

    if($key == "showReplay") {
      print("wwww");
    }
}
    if ($key =="mail") {

    print('<div class="gravatar">');


      $size = 40;
      $email = $value;
      $default = "http://www.gravatar.com/avatar/00000000000000000000000000000000";
      $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;

      print("<img src=$grav_url alt='' height='42' width='42' />");


    print("</div>");
    print("</div>");
  }
  if (isset($edit)) {
  /*  print("<input type='submit' name='doSave' value='spara' onClick=\"this.form.action = 'this'\"");
    print("<input type='submit' name='doSave' value='spara' onClick=\"this.form.action = '<?=$this->url->create($save)?>'\"");
  print("<input type='submit' name='doRemoveOne' value='Ta bort' onClick=\"this.form.action = '<?=$this->url->create($removeId)?>'\"");*/
  }else{
  /*  print("<input type='submit' name='doSave' value='spara' onClick=\"this.form.action = 'this'\"");
    print("<input type='submit' name='doBack' value='back' onClick=\"this.form.action = '<?=$this->url->create($back)?>'\"");
//    print("<input type='submit' name='doEdit' value='edit' onClick=\"this.form.action = '<?=$this->url->create($edit)?>'\"");
//    print("<input type='submit' name='doReplay' value='replay' onClick=\"this.form.action = '<?=$this->url->create($replay)?>'\"");
//    print("<input type='submit' name='doRemoveOne' value='Ta bort' onClick=\"this.form.action = '<?=$this->url->create($removeId)?>'\"");*/
  }


    }
    //print("</div>");
    }

  }

}

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
<?php $isArr = false; ?>
<?php foreach ($comment as $key => $value) : ?>

<?php if ($key == "mail") : ?><?php $mail = $value; ?><?php endif; ?>
<?php if ($key == "id") : ?><?php $id = $value; ?><?php endif; ?>
<?php if ($key == "name") : ?><?php $name = array('name' => $value);?><?php endif; ?>
<?php if ($key == "content") : ?><?php $content = array('content' => $value);?><?php endif; ?>
<?php if ($key == "web") : ?><?php $web = $value; ?><?php endif; ?>
<?php if ($key == "ip") : ?><?php $ip = $value; ?><?php endif; ?>
<?php if ($key == "timestamp") : ?><?php $timestamp = $value; ?><?php endif; ?>
<?php if ($key == "edit") : ?><?php $setEdit = $value; ?><?php endif; ?>
<?php if ($key == "replay") : ?><?php if(is_array($value)) {$isArr = true; $setInnerArray = $value;} ?><?php endif; ?>
<?php endforeach; ?>





<div class="comment">
$innerarray = '';
  <?php if ($mail) : ?>
    <?php print('<div class="gravatar">') ?>

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


<?php if ($id) : ?>  <?php print("<br /><br /><br />")?>

<form method=post>
  <?php if($router == "home") : ?>
    <input type=hidden name="redirect" value="<?=$this->url->create('')?>">
  <?php endif; ?>

  <?php if($router != "home") : ?>
    <input type=hidden name="redirect" value="<?=$this->url->create($router)?>">
  <?php endif; ?>

  <?php
    $edit = "comment/edit/$router/$id";
    $replay = "comment/replay/$router/$id";
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
    <input type='submit' name='doReplay' value='replay' onClick="this.form.action = '<?=$this->url->create($replay)?>'"/>
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
  //test6($content);
  //test6($name);
  test6($name);
}
?>

<?php endif; ?>
</form>

</div>
<div>
  <?php if($isArr) : ?>

    <?php foreach ($setInnerArray as $id => $comment) : ?>
    <?php foreach ($comment as $key => $value) : ?>

    <?php if ($key == "mail") : ?><?php $mail = $value; ?><?php endif; ?>
    <?php if ($key == "postid") : ?><?php $id = $value; ?><?php endif; ?>
    <?php if ($key == "name") : ?><?php $name = array('name' => $value);?><?php endif; ?>
    <?php if ($key == "content") : ?><?php $content = array('content' => $value);?><?php endif; ?>
    <?php if ($key == "web") : ?><?php $web = $value; ?><?php endif; ?>
    <?php if ($key == "ip") : ?><?php $ip = $value; ?><?php endif; ?>
    <?php if ($key == "timestamp") : ?><?php $timestamp = $value; ?><?php endif; ?>
    <?php if ($key == "edit") : ?><?php $setEdit = $value; ?><?php endif; ?>
    <?php if ($key == "replay") : ?><?php if(is_array($value)) {$isArr = true;} ?><?php endif; ?>
    <?php endforeach; ?>

    <div class="commento">
      <form method=post>
        <?php if($router == "home") : ?>
          <input type=hidden name="redirect" value="<?=$this->url->create('')?>">
        <?php endif; ?>

        <?php if($router != "home") : ?>
          <input type=hidden name="redirect" value="<?=$this->url->create($router)?>">
        <?php endif; ?>

        <?php
          $edit = "comment/edit/$router/$id";
          $replay = "comment/replay/$router/$id";
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
          <input type='submit' name='doReplay' value='replay' onClick="this.form.action = '<?=$this->url->create($replay)?>'"/>
          <input type='submit' name='doRemoveOne' value='Ta bort' onClick="this.form.action = '<?=$this->url->create($removeId)?>'"/>
        <?php endif; ?>

      </form>

        <?php print("$id<br />");?>
        <?php if($name) {print($name['name']);}?>

    </div>
  <?php endforeach; ?>
  <?php endif; ?>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php
print("<br />-------------<br /><br />");
testr($comments,"parent");
print("<br />-------------<br /><br />");

?>
</div>
