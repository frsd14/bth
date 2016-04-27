<?php
   class code {
      var $name = "";
      var $var2 = "constant string";
      var $obj = "";
      var $router ="";
      var $id = "";

      /*
      $edit = "comment/edit/$router/$id";
      $replay = "comment/replay/$router/$id";
      $save = "comment/save/$router/$id";
      $removeId = "comment/remove-one/$router/$id";
      $addResponse = "comment/addResponse/$router/$id";
      */

      function setRouter($router) {
        //if($router == 'home')
        //  $this->router = '';
        //else
          $this->router = $router;
      }
      function getRouter() {
        return $this->router;
      }
      function setId($id) {
        $this->id = $id;
      }
      function getId() {
        return $this->id;
      }
      function myfunc ($arg1, $arg2) {
      }
      function setName($name)
      {
        $this->name = $name;
      }
      function getName()
      {
        return "$this->name";
      }

      function test () {
        return "hello";
      }
      function setContext($obj) {
        $this->obj = $obj;
      }

      function getContext() {
        return $this->obj;
      }

      function getEdit() {
        $edit = "comment/edit/$this->router/$this->id";
        $bob = $this->obj->url->create($edit);
        $test = "<input type='submit' name='doEdit' value='edit' onClick=\"this.form.action = '$bob'\"/>";
        return $test;
      }
      function getReplay() {
        $reply = "comment/reply/$this->router/$this->id";
        $bob = $this->obj->url->create($reply);
        $test = "<input type='submit' name='doReplay' value='replay' onClick=\"this.form.action = '$bob'\"/>";
        return $test;
      }
      function getBtn() {


        if($this->router == "home") {
          $bob = $this->obj->url->create('');
        } else {
          $bob = $this->obj->url->create($this->router);
        }

        return "<input type=hidden name='redirect' value=$bob >";
      }



   }
?>
