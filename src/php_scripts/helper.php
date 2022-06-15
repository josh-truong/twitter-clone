<?php
   function createDirectory($dirPath) {
      if (!file_exists($dirPath)) {
         mkdir($dirPath, 0777, true);
       }
   }

   function getUID() {
      
      $db = new DB();
      $ip = $_SERVER['REMOTE_ADDR'];
      $uid = $db->query("select uid from users where ip=?", [$ip]);
    
      if (!$uid->rowCount()) {
         $db->query("insert into users(ip) values(?)", [$ip]);
         $uid = $db->query("select uid from users where ip=?", [$ip]);
      }
      return $uid->fetch()['uid'];
   }
?>