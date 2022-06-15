<?php
   require_once('php_scripts/debug.php');
   require_once('php_scripts/mysql.php');
   require_once('php_scripts/helper.php');
   function card($tid, $uid, $post, $date, $file) {
      $db = new DB();
      $user = getUID();
      $follow = $db->query("select follower from follows where uid=:user and follower=:uid", 
         ['user'=>$user, 'uid'=>$uid]);

      $img = NULL;
      if ($file) {
         $src = $file ? 'uploads/'.$file : $file;
         $img = <<<HTML
         <img src=$src class="card-img-top" style='border-radius:30px;' alt=$file>
         HTML;
      }

      if (!$follow->rowCount()) {
         $follow = <<<HTML
         <a href=index.php?follow=$uid class="btn btn-primary">Follow</a>
         HTML;
      } else {
         $follow = <<<HTML
         <a href=index.php?unfollow=$uid class="btn btn-primary">Unfollow</a>
         HTML;
      }

      $date = date("M d", strtotime($date));
      

      return <<<HTML
      <div class="card" style="margin: 0 auto; padding:0 60px 0 60px;">
         <div class="card-body">
            <div style='display:flex;'>
               <h5 class="card-title">User $uid @$uid · $date</h5>
               <div style='margin-left: auto;'> $follow </div>
            </div>
            <p class="card-text">$post</p>
            $img
            <br/>
            <div class='row' style="padding-top:20px;">
               <div class='col'>
                  <a href='#'>
                     <i class="fa-solid fa-comment"></i>
                  </a>
               </div>
               <div class='col'>
                  <a href='#'>
                     <i class="fa-solid fa-retweet"></i>
                  </a>
               </div>
               <div class='col'>
                  <a href='#'>
                     <i class="fa-solid fa-heart"></i>
                  </a>
               </div>
               <div class='col'>
                  <a href='#'>
                     <i class="fa-solid fa-arrow-up-from-bracket"></i>
                  </a>
               </div>
            </div>
         </div>
      </div>
      HTML;
   }
?>
