<?php
   require('php_scripts/debug.php');
   require('php_scripts/mysql.php');
   require('php_scripts/helper.php');
   require('php_scripts/TweetCard.php');

   $db = new DB();
   $uid = getUID();
   $upload_msg = '';


   if (isset($_POST['submit']))  {
      $tweet = $_POST['tweet'] ? $_POST['tweet'] : NULL;
      $file = $_FILES['file']['error'] == 0 ? $_FILES['file'] : NULL;
      $error = false;
      if ($tweet || $file) {
         $date = Date("Y-m-d H:i:s");

         if ($file) {
            $fileExt = explode('.', $file['name']); # [filename, file extension]
            $fileActualExt = strtolower(end($fileExt)); # get file extension
            $fileUID = uniqid('', true).".".$fileActualExt; # create unique file name

            $uploads_dir = 'uploads/';
            createDirectory($uploads_dir);
            
            $fileDestination = $uploads_dir.$fileUID;
            $tname = $file['tmp_name'];


            $error = move_uploaded_file($tname, $fileDestination) ? false : true;

            $upload_msg = $error ? "File not uploaded." : "File Sucessfully uploaded";
            $file = $fileUID;
         }

         if (!$error) {
            $db->query("insert into tweets (uid, post, date, file) values(?,?,?,?)", 
            [$uid, $tweet, $date, $file]);
         }
      }
   }


   if (isset($_REQUEST['follow'])) {
      $follow = $_REQUEST['follow'];
      $db->query("insert ignore into follows(uid, follower) values(?,?)", [$uid, $follow]);
   }

   if (isset($_REQUEST['unfollow'])) {
      $follow = $_REQUEST['unfollow'];
      $db->query("delete from follows where uid=? and follower=?", [$uid, $follow]);
   }
?>


<!DOCTYPE HTML>
<html lang='en'>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Twitter</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   </head>
   <body>
      <div style="padding:0 30% 0 30%">
         <?php include 'php_scripts/tweet_form.php'?>
         <?=$upload_msg?>
         <br/><br/><br/>
         <h3>Follows</h3>
         <?php
            $result = $db->query("select * from tweets order by date desc", [])->fetchAll();
            $user = getUID();
            $count_follows = 0;
            foreach($result as $row) {
               [$tid, $uid, $date, $post, $file] = $row;
               
               $follow = $db->query("select follower from follows where uid=:user and follower=:uid", 
                  ['user'=>$user, 'uid'=>$uid])->rowCount();
               if ($follow) {
                  echo card($tid, $uid, $post, $date, $file);
                  ++$count_follows;
               }
            }
            if (!$count_follows) {
               echo "<h5 class='text-center'>Find people on Twitter.</h5>";
            }
         ?>
         <hr/>
         
         <h3>Explore</h3>
         <?php
            foreach($result as $row) {
               [$tid, $uid, $date, $post, $file] = $row;
               $follow = $db->query("select follower from follows where uid=:user and follower=:uid", 
                  ['user'=>$user, 'uid'=>$uid])->rowCount();
               if (!$follow) {
                  echo card($tid, $uid, $post, $date, $file);
               }
            }
         ?>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   </body>
</html>
