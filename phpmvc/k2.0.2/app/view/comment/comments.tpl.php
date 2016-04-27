<?php print_r($comments); ?>

<h2>Comments</h2>

<?php
  function test5($param,$focus) {

    $paramArray = array('content'=>'test');

    foreach($param as $paramName => $paramValue)
    {
    print("<div class=$paramName>");
    if($paramName == 'content') {
      print ("<p><label>$paramName<br/><textarea name='$paramName'/>$paramValue</textarea></label></p>");
    }else {
      if($focus) {
        print ("<p><label>$paramName<br/><input type='text' name='$paramName' value='$paramValue' autofocus /></label></p>");
      } else {
        print ("<p><label>$paramName<br/><input type='text' name='$paramName' value='$paramValue' /></label></p>");
      }
    }
    print('</div>');
    }
  }
  function test6($param) {

    $paramArray = array('content'=>'test');

    foreach($param as $paramName => $paramValue)
    {
    print("<div class=$paramName>");
    print ("<p><label>$paramName : $paramValue</label></p>");
    print('</div>');
    }
  }
?>


<?php if (is_array($comments)) : ?>
<div class='comments'>

  <?php foreach ($comments as $id => $comment) : ?>
  <?php $isArr = false; ?>
  <?php foreach ($comment as $key => $value) : ?>
  <?php if ($key == "mail") : ?><?php $mail = $value; $em = array('mail' => $value);?><?php endif; ?>
  <?php if ($key == "id") : ?><?php $id = $value; ?><?php endif; ?>
  <?php if ($key == "name") : ?><?php $name = array('name' => $value);?><?php endif; ?>
  <?php if ($key == "content") : ?><?php $content = array('content' => $value);?><?php endif; ?>
  <?php if ($key == "currComment") : ?><?php $focus = $value;?><?php endif; ?>
  <?php if ($key == "web") : ?><?php $web = array('web' => $value);?><?php endif; ?>
  <?php if ($key == "ip") : ?><?php $ip = $value; ?><?php endif; ?>
  <?php if ($key == "timestamp") : ?><?php $timestamp = $value; ?><?php endif; ?>
  <?php if ($key == "edit") : ?><?php $setEdit = $value;?><?php endif; ?>
  <?php if ($key == "replay") : ?><?php if(is_array($value)) {$isArr = true; $setInnerArray = $value;} ?><?php endif; ?>
  <?php endforeach; ?>

<div class='comment' id='<?=$id?>' ><form method=post>
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
    <div class="btn">
    <input type='submit' name='doSave' value='spara' onClick="this.form.action = '<?=$this->url->create($save)?>'"/>
    <input type='submit' name='doRemoveOne' value='Ta bort' onClick="this.form.action = '<?=$this->url->create($removeId)?>'"/>
    </div>
  <?php else : ?>
    <div class="btn">
    <input type='submit' name='doBack' value='back' onClick="this.form.action = '<?=$this->url->create($back)?>'"/>
    <input type='submit' name='doEdit' value='edit' onClick="this.form.action = '<?=$this->url->create($edit)?>'"/>
    <?php if(isset($focus) && $focus == true) :?>
      <input type='submit' name='doReplay' value='replay' onClick="this.form.action = '<?=$this->url->create($replay)?>'"/>
  <?php else :?>
    <?php $focus = false; ?>
    <input type='submit' name='doReplay' value='replay' onClick="this.form.action = '<?=$this->url->create($replay)?>'"/>
  <?php endif; ?>
    <input type='submit' name='doRemoveOne' value='Ta bort' onClick="this.form.action = '<?=$this->url->create($removeId)?>'"/>
    </div>
  <?php endif; ?>
<div class="gravatar">
<?php
$size = 40;
$email = $mail;
$default = "http://www.gravatar.com/avatar/00000000000000000000000000000000";
$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
?>
<img src="<?php echo $grav_url; ?>" alt="" height="42" width="42" />


</div>
<?php

if($setEdit) {
  test5($name,$focus);
  test5($content,$focus);
  test5($web,$focus);
} else {
  test6($name);
  test6($content);
  test6($web);
}
?>
</form>
<div class="added">
<?php print(date("Y-m-d H:i:s",$timestamp)) ?>
</div>
</div>








<?php if ($isArr) : ?>
<?php $headId = $id;?>
  <?php foreach ($setInnerArray as $id => $comment) : ?>
  <?php $isArr = false; ?>
  <?php foreach ($comment as $key => $value) : ?>
  <?php if ($key == "mail") : ?><?php $mail = $value; ?><?php endif; ?>
  <?php if ($key == "id") : ?><?php $id = $value; ?><?php endif; ?>
  <?php if ($key == "name") : ?><?php $name = array('name' => $value);?><?php endif; ?>
  <?php if ($key == "currComment") : ?><?php $focus = $value;?><?php endif; ?>
  <?php if ($key == "content") : ?><?php $content = array('content' => $value);?><?php endif; ?>
  <?php if ($key == "web") : ?><?php $web = $value; ?><?php endif; ?>
  <?php if ($key == "ip") : ?><?php $ip = $value; ?><?php endif; ?>
  <?php if ($key == "timestamp") : ?><?php $timestamp = $value; ?><?php endif; ?>
  <?php if ($key == "edit") : ?><?php $setEdit = $value;?><?php endif; ?>
  <?php if ($key == "replay") : ?><?php if(is_array($value)) {$isArr = true; $setInnerArray = $value;} ?><?php endif; ?>
  <?php endforeach; ?>



<div class='commento'><form method=post>
  <?php if($router == "home") : ?>
    <input type=hidden name="redirect" value="<?=$this->url->create('')?>">
  <?php endif; ?>
  <?php if($router != "home") : ?>
    <input type=hidden name="redirect" value="<?=$this->url->create($router)?>">
  <?php endif; ?>

  <?php
    $edit = "comment/edit/$router/$id";
    $replay = "comment/replay/$router/$id";
    $editReplay = "comment/edit-replay/$router/$id/$headId";
    $replayReplay = "comment/replay-replay/$router/$id/$headId";
    $saveReplay = "comment/save-replay/$router/$id/$headId";
    $save = "comment/save/$router/$id";
    $removeId = "comment/remove-one-replay/$router/$id/$headId";
    $addResponse = "comment/addResponse/$router/$id";
  ?>

  <?php if ($setEdit) : ?>
    <div class="btn">
    <input type='submit' name='doSaveReplay' value='spara svar' onClick="this.form.action = '<?=$this->url->create($saveReplay)?> '"/>
    <input type='submit' name='doRemoveOneReplay' value='Ta bort' onClick="this.form.action = '<?=$this->url->create($removeId)?>'"/>
    <input type='submit' name='doReplayReplay' value='replayReplay' onClick="this.form.action = '<?=$this->url->create($replayReplay)?>'"/>
    </div>
  <?php else : ?>
    <div class="btn">
    <input type='submit' name='doBack' value='back' onClick="this.form.action = '<?=$this->url->create($back)?>'"/>
    <input type='submit' name='doEditReplay' value='edit' onClick="this.form.action = '<?=$this->url->create($editReplay)?>'"/>
    <input type='submit' name='doReplay' value='replay' onClick="this.form.action = '<?=$this->url->create($replay)?>'"/>
    <?php if(isset($focus) && $focus == true) :?>
    <input type='submit' name='doReplayReplay' value='replayReplay' onClick="this.form.action = '<?=$this->url->create($replayReplay)?>'"/>
  <?php else : ?>
    <?php $focus = false; ?>
    <input type='submit' name='doReplayReplay' value='replayReplay' onClick="this.form.action = '<?=$this->url->create($replayReplay)?>'"/>
  <?php endif; ?>
    <input type='submit' name='doRemoveOneReplay' value='Ta bort' onClick="this.form.action = '<?=$this->url->create($removeId)?>'"/>

    </div>
  <?php endif; ?>
<div class="gravatar">
<?php
$size = 40;
$email = $mail;
$default = "http://www.gravatar.com/avatar/00000000000000000000000000000000";
$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
?>
<img src="<?php echo $grav_url; ?>" alt="" height="42" width="42" />

</div>
<?php

if($setEdit) {
  test5($content,$focus);
  test5($name,$focus);

} else {
  test6($content);
  test6($name);
}
?>
</form>
<div class="added">
<?php print(date("Y-m-d H:i:s",$timestamp)) ?>
</div>
</div>
<?php endforeach; ?>
<?php endif ?>
<?php endforeach; ?>
<?php endif ?>
