<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($params)
    {


        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->findAll($params);

        $this->views->add('comment/comments', [
            'comments' => $all,
            'router' => $params,
        ]);
    }

    /**
     * Return size of session-array.
     *
     * @return void
     */
    public function count($params)
    {
        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);
        return count($comments->findAll($params));
    }


    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction($param)
    {

        $isPosted = $this->request->getPost('doCreate');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
          'content'   => $this->request->getPost('content'),
          'name'      => $this->request->getPost('name'),
          'web'       => $this->request->getPost('web'),
          'mail'      => $this->request->getPost('mail'),
          'timestamp' => time(),
          'ip'        => $this->request->getServer('REMOTE_ADDR'),
          'id'        => uniqid(),
          'edit'        => false,
          'showReplay' => false,
          'currComment' => true,
        ];

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comments->add($comment, $param);

        $this->response->redirect($this->request->getPost('redirect'));

    }
    /**
     * Add a comment.
     *
     * @return void
     */
    public function replayAction($router,$commentId)
    {
        $isPosted = $this->request->getPost('doReplay');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content'   => "constart",
            'name'      => "start",
            'web'       => "Webconstart",
            'mail'      => "Webconstart",
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
            'id'        => uniqid(),
            'edit'      => true,
            'currComment' => true,
        ];

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->replay($router, $commentId, $comment);

        $this->response->redirect($this->request->getPost('redirect'));

    }
    /**
     * Add a comment.
     *
     * @return void
     */
    public function replayReplayAction($router,$commentId, $replayId)
    {
        $isPosted = $this->request->getPost('doReplayReplay');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content'   => "replayReplay",
            'name'      => "replayReplay",
            'web'       => "replayReplay",
            'mail'      => "Webconstart",
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
            'id'        => uniqid(),
            'edit'      => true,
            'currComment' => true,
        ];

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->replayreplay($router, $commentId, $replayId, $comment);

        $this->response->redirect($this->request->getPost('redirect'));
    }

    /**
     * Add a comment.
     *
     * @return void
     */
    public function saveReplayAction($router,$commentId,$replayId)
    {


        $isPosted = $this->request->getPost('doSaveReplay');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
          'content'   => $this->request->getPost('content'),
          'name'      => $this->request->getPost('name'),
          'web'       => $this->request->getPost('web'),
          'mail'      => $this->request->getPost('mail'),
          'timestamp' => time(),
          'ip'        => $this->request->getServer('REMOTE_ADDR'),
          'id'        => uniqid(),
          'edit'        => false,
          'showReplay' => false,
        ];
        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->saveReplay($router, $commentId, $replayId, $comment);

        $this->response->redirect($this->request->getPost('redirect'));
    }


    /**
     * Add a comment.
     *
     * @return void
     */
    public function addResponseAction($param1, $param2)
    {
      print_r($param1);
      print_r($param2);

        $isPosted = $this->request->getPost('doResponse');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }


        $comment = [
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
            'id'        => uniqid(),
        ];

        //$comments = new \Phpmvc\Comment\CommentsInSession();
        //$comments->setDI($this->di);

        //$comments->add($comment, $param);

        //$this->response->redirect($this->request->getPost('redirect'));
    }

    /**
     * Remove all comments.
     *
     * @return void
     */
    public function removeAllAction($router)
    {
        $isPosted = $this->request->getPost('doRemoveAll');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comments->deleteAll($router);

        $this->response->redirect($this->request->getPost('redirect'));
    }

    /**
     * Remove one comments.
     *
     * @return void
     */
    public function removeOneAction($router,$commentId)
    {
        $isPosted = $this->request->getPost('doRemoveOne');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->deleteOne($router, $commentId);

        $this->response->redirect($this->request->getPost('redirect'));
    }
    /**
     * Remove one comments.
     *
     * @return void
     */
    public function removeOneReplayAction($router,$commentId,$replayId)
    {
        $isPosted = $this->request->getPost('doRemoveOneReplay');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->deleteOneReplay($router, $commentId, $replayId);

        $this->response->redirect($this->request->getPost('redirect'));
    }
    /**
     * Remove one comments.
     *
     * @return void
     */
    public function saveAction($router,$commentId)
    {
      $isPosted = $this->request->getPost('doSave');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
        ];

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->save($router, $commentId, $comment);

        $this->response->redirect($this->request->getPost('redirect'));
    }

    public function editAction($router,$commentId)
    {
      $isPosted = $this->request->getPost('doEdit');

      if (!$isPosted) {
          $this->response->redirect($this->request->getPost('redirect'));
      }

      $comments = new \Phpmvc\Comment\CommentsInSession();
      $comments->setDI($this->di);

      $all = $comments->edit($router, $commentId);

      $this->response->redirect($this->request->getPost('redirect'));
    }

    public function editReplayAction($router,$commentId, $replayId)
    {
      $isPosted = $this->request->getPost('doEditReplay');

      if (!$isPosted) {
          $this->response->redirect($this->request->getPost('redirect'));
      }

      $comments = new \Phpmvc\Comment\CommentsInSession();
      $comments->setDI($this->di);

      $all = $comments->editReplay($router, $commentId, $replayId);

      $this->response->redirect($this->request->getPost('redirect'));
    }


    public function showReplayAction($router,$commentId)
    {

      $isPosted = $this->request->getPost('doShowReplay');

      if (!$isPosted) {
          $this->response->redirect($this->request->getPost('redirect'));
      }

      $comments = new \Phpmvc\Comment\CommentsInSession();
      $comments->setDI($this->di);

      $all = $comments->showReplay($router, $commentId);

      $this->response->redirect($this->request->getPost('redirect'));
    }
}
