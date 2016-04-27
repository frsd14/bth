<div class='comment-form'>
    <form method=post>

      <?php if($router == "home") : ?>
        <input type=hidden name="redirect" value="<?=$this->url->create('')?>">
      <?php endif; ?>

      <?php if($router != "home") : ?>
        <input type=hidden name="redirect" value="<?=$this->url->create($router)?>">
      <?php endif; ?>

        <div class="submitForm">

        <legend>Leave a comment</legend>
        <p><label>Comment:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Name:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Homepage:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>

          <?php
            if($router){
              $add = "comment/add/$router";
              $removeAll = "comment/remove-all/$router";
            }
          ?>

          <input type='submit' name='doCreate' value='Comment' onClick="this.form.action = '<?=$this->url->create($add)?>'"/>
          <input type='reset' value='Reset'/>
          <input type='submit' name='doRemoveAll' value='Remove all' onClick="this.form.action = '<?=$this->url->create($removeAll)?>'"/>

        </p>
        <output><?=$output?></output>
      </div>
      </form>
</div>
