<?php  
    
    function getCreateUserAccount($userid = 0) {

      if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
           $url = "https://";   
      else  
           $url = "http://";   
      // Append the host(domain name, ip) to the URL.   
      $url.= $_SERVER['HTTP_HOST'];   
      
      // Append the requested resource location to the URL   
      $url.= "/serverDna/login_module/authenticate.php";
      
      $url.="?id=" . $userid;
      return $url; 
    }
  ?>   