<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentsInSession implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function looper($loopArray, $loopValue, $param){

      foreach ($loopArray as $id => $arr) {
          foreach ($arr as $key => $value) {
            if($key == $loopValue) {
              $loopArray[$id][$loopValue] = $param;
          }
      }
    }
      return $loopArray;
    }


    /**
     * Add a new comment.
     *
     * @param array $comment with all details.
     *
     * @return void
     */
    public function add($comment, $param)
    {
/*
      $comments = $this->session->get($param, []);

foreach ($comments as $id => $arr) {
    foreach ($arr as $key => $value) {
      if($key == 'currComment') {
        $comments[$id]['currComment'] = false;
    }
}
}
*/


  //    $comments[] = $comment;
      $comments = $this->looper($this->session->get($param, []),'currComment',false);
      $comments[] = $comment;
      $this->session->set($param, $comments);
    }
    /**
     * Add a new comment.
     *
     * @param array $comment with all details.
     *
     * @return void
     */
    public function replay($router, $commentId, $comment)
    {

      $comments = $this->session->get($router, []);
      foreach ($comments as $id => $arr) {
          foreach ($arr as $key => $value) {
            if($key == 'currComment') {
              $comments[$id]['currComment'] = false;
          }
            if($key == 'id' && $value == $commentId) {
              $getArrayPost = $id;


          }
      }
      }

      foreach ($comments[$getArrayPost]['replay'] as $id => $arr) {
          foreach ($arr as $key => $value) {
            if($key == 'currComment') {
              $comments[$getArrayPost]['replay'][$id]['currComment'] = false;
          }
      }
    }

        $comments[$getArrayPost]['replay'][] = $comment;

        $this->session->set($router, $comments);
    }
    /**
     * Add a new comment.
     *
     * @param array $comment with all details.
     *
     * @return void
     */
    public function replayreplay($router, $commentId, $replayId, $comment)
    {


        $comments = $this->session->get($router, []);

        $getArrayPost = 0;
        $getArrayPostComment = 0;

        foreach ($comments as $id => $arr) {
            foreach ($arr as $key => $value) {
              if($key == 'id' && $value == $replayId) {
                $getArrayPost = $id;
            }
        }
      }
      $findPost = $comments[$getArrayPost];
                foreach ($findPost as $key => $value) {
                  if($key == 'replay') {
                    $replayArr = $value;
    }

    }
          foreach ($replayArr as $id => $arr) {
              foreach ($arr as $key => $value) {
                if($key == 'id' && $value == $commentId) {
                  $getArrayPostComment = $id;
    }
  }

  }

  array_splice( $comments[$getArrayPost]['replay'], $getArrayPostComment+1, 0, array($comment)); // splice in at position 3

        $this->session->set($router, $comments);
    }




    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     *
     */
    public function findAll($param)
    {
        return $this->session->get($param, []);
    }


    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     */
    public function findOne($param)
    {
        $comments = $this->session->get('comments', []);

        unset($comments[$param]);

        $this->session->set('comments', $comments);
    }



    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteAll($router)
    {
        $this->session->set($router, []);
    }
    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteOne($router, $commentId)
    {
      $comments = $this->session->get($router, []);

      $getArrayPost = 0;

      foreach ($comments as $id => $arr) {
          foreach ($arr as $key => $value) {
            if($key == 'id' && $value == $commentId) {
              $getArrayPost = $id;
          }
      }
    }
      unset($comments[$getArrayPost]);
      $this->session->set($router, $comments);
    }
    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteOneReplay($router, $commentId, $replayId)
    {
      $comments = $this->session->get($router, []);

      $getArrayPost = 0;
      $getArrayPostComment = 0;

      foreach ($comments as $id => $arr) {
          foreach ($arr as $key => $value) {
            if($key == 'id' && $value == $replayId) {
              $getArrayPost = $id;
          }
      }
    }
    $findPost = $comments[$getArrayPost];
              foreach ($findPost as $key => $value) {
                if($key == 'replay') {
                  $replayArr = $value;
  }

  }
        foreach ($replayArr as $id => $arr) {
            foreach ($arr as $key => $value) {
              if($key == 'id' && $value == $commentId) {
                $getArrayPostComment = $id;
  }
}

}
    unset($comments[$getArrayPost]['replay'][$getArrayPostComment]);


      $this->session->set($router, $comments);

    }


    public function save($router, $commentId, $comment)
    {
      $comments = $this->session->get($router, []);

      foreach ($comments as $id => $arr) {
          foreach ($arr as $key => $value) {
            if($key == 'id' && $value == $commentId) {
              $getArrayPost = $id;
          }
      }
    }
    $comments[$getArrayPost]['name'] = $comment['name'];
    $comments[$getArrayPost]['content'] = $comment['content'];
    $comments[$getArrayPost]['edit'] = false;

    $this->session->set($router, $comments);



    }
    public function saveReplay($router, $commentId, $replayId, $comment)
    {
      $comments = $this->session->get($router, []);

      $getArrayPost = 0;
      $getArrayPostComment = 0;

      foreach ($comments as $id => $arr) {
          foreach ($arr as $key => $value) {
            if($key == 'id' && $value == $replayId) {
              $getArrayPost = $id;
          }
      }
    }
    $findPost = $comments[$getArrayPost];
              foreach ($findPost as $key => $value) {
                if($key == 'replay') {
                  $replayArr = $value;
  }

  }
        foreach ($replayArr as $id => $arr) {
            foreach ($arr as $key => $value) {
              if($key == 'id' && $value == $commentId) {
                $getArrayPostComment = $id;
  }
}

}
    $comments[$getArrayPost]['replay'][$getArrayPostComment]['name'] = $comment['name'];
    $comments[$getArrayPost]['replay'][$getArrayPostComment]['content'] = $comment['content'];
    $comments[$getArrayPost]['replay'][$getArrayPostComment]['web'] = $comment['web'];
    $comments[$getArrayPost]['replay'][$getArrayPostComment]['edit'] = false;

    $this->session->set($router, $comments);

    }

    public function edit($router, $commentId)
    {
      $comments = $this->session->get($router, []);

      foreach ($comments as $id => $arr) {
          foreach ($arr as $key => $value) {
            if($key == 'id' && $value == $commentId) {
              $getArrayPost = $id;
          }
      }
    }
    $comments[$getArrayPost]['edit'] = true;

    $this->session->set($router, $comments);
    }

    public function editReplay($router, $commentId, $replayId)
    {

      $comments = $this->session->get($router, []);

      $getArrayPost = 0;
      $getArrayPostComment = 0;

      foreach ($comments as $id => $arr) {
          foreach ($arr as $key => $value) {
            if($key == 'id' && $value == $replayId) {
              $getArrayPost = $id;
          }
      }
    }
    $findPost = $comments[$getArrayPost];
              foreach ($findPost as $key => $value) {
                if($key == 'replay') {
                  $replayArr = $value;
  }

  }
        foreach ($replayArr as $id => $arr) {
            foreach ($arr as $key => $value) {
              if($key == 'id' && $value == $commentId) {
                $getArrayPostComment = $id;
  }
}

}
$comments[$getArrayPost]['replay'][$getArrayPostComment]['edit'] = true;



    $this->session->set($router, $comments);
    }


    public function showReplay($router, $commentId)
    {
      $comments = $this->session->get($router, []);

      foreach ($comments as $id => $arr) {
          foreach ($arr as $key => $value) {
            if($key == 'id' && $value == $commentId) {
              $getArrayPost = $id;
          }
      }
    }
    $comments[$getArrayPost]['showReplay'] = true;

    $this->session->set($router, $comments);
    }
}
