<?php
    
    session_start();
?>


<?php
   
    include_once "config.php";
    try{
        if (isset($_POST["submit"])){
            if ($_POST["username"]=="" OR $_POST["password"]==""){
                echo '<script type="text/javascript">alert1("Enter all Detail");</script>';
                
            }            
            else{
             

                $username=$_POST["username"];
                $password=$_POST["password"];

                if (is_numeric($username)) {
                $login = $conn->prepare("SELECT * FROM [User] WHERE user_id = ? OR  username = ?");
                $login->execute([$username,$username]);
                $alldata = $login->fetchAll(PDO::FETCH_ASSOC);

                $rowCount = count($alldata);
                $data=$alldata[0];
                                    
                }
                else{
                $login = $conn->prepare("SELECT * FROM [User] WHERE username = ?");
                $login->execute([$username]);
                $alldata = $login->fetchAll(PDO::FETCH_ASSOC);

                $rowCount = count($alldata);
                $data=$alldata[0];
                
                }

                if ($rowCount>0 && ($data['user_id']===$username || $data['username']===$username )) {
                    if (password_verify($password,$data["password"])){

                        $login_type=$data["login_id"];
                        $dep_id=dep_login($data["user_id"]);
                        $sec_id=sec_login($data["user_id"]); 
                        switch ($login_type) {
                            case 1:
                                if($dep_id){
                                    $_SESSION["user_id"]=$data["user_id"];
                                    $_SESSION["username"]=$data["username"];
                                    $_SESSION["dep_id"]=$dep_id;                                    
                                    $_SESSION['start'] = time(); 
                                    $_SESSION['expire'] = $_SESSION['start'] + (60 * 60); //session work for 60 minute
                                    
                                    header("location: department/dashboard.php");
                                    break;                                    
                                }
                                elseif ($sec_id) {
                                    $_SESSION["username"]=$data["username"];
                                    $_SESSION["user_id"]=$data["user_id"];
                                    // $_SESSION["sec_id"]=$sec_id['Section_id'];       
                                    // $_SESSION["dep_id"]=$sec_id['department_id'];         
                                    $_SESSION['start'] = time(); 
                                    $_SESSION['expire'] = $_SESSION['start'] + (60 * 60); //session work for 60 minute
                                    
                                    header("location: section/dashboard.php");
                                    break;                                    
                                }
                                else{
                                    $_SESSION["username"]=$data["username"];
                                    $_SESSION["user_id"]=$data["user_id"];
                                    // $_SESSION["sec_id"]=$sec_id['Section_id'];       
                                    // $_SESSION["dep_id"]=$sec_id['department_id'];         
                                    $_SESSION['start'] = time(); 
                                    $_SESSION['expire'] = $_SESSION['start'] + (60 * 60); //session work for 60 minute
                                    
                                    header("location: section/dashboard.php");
                                    break; 
                                }


                            case 2:
                                $_SESSION["financer"]=$data["username"];
                                $_SESSION["user_id"]=$data["user_id"];
                                $_SESSION['start'] = time(); 
                                $_SESSION['expire'] = $_SESSION['start'] + (60 * 60); //session work for 60 minute
                                header("location: finance/dashboard.php");
                                break;
                            case 3:
                                $_SESSION["contractor"]=$data["username"];
                                $_SESSION["user_id"]=$data["user_id"];
                                $_SESSION['start'] = time(); 
                                $_SESSION['expire'] = $_SESSION['start'] + (60 * 60); //session work for 60 minute
                                header("location: contractor/dashboard.php");
                                break;
                            case 4:
                                $_SESSION["admin"]=$data["username"];
                                $_SESSION["user_id"]=$data["user_id"];
                                $_SESSION['start'] = time(); 
                                $_SESSION['expire'] = $_SESSION['start'] + (60 * 60); //session work for 60 minute
                                header("location: hr/dashboard.php");
                                break;
                            default :
                                $_SESSION['error'] = "User can not mapped with role!!";
                                header("Location: index.php"); 
                        }   
                    }
                    else{
                        $_SESSION['error'] = "Invalid password";
                        header("Location: index.php");             }
                }
                else{
                    $_SESSION['error'] = "Invalid username";
                    header("Location: index.php");
                }
      
            }
    }
}


catch(PDOException $e){
    $_SESSION['error']=$e->getMessage();
     header("Location: index.php");


}
function dep_login($user_id){
            global $conn;
            $fetch_query = "SELECT department_id FROM [Department] WHERE user_id = ?";
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $conn->prepare($fetch_query);
            $sql->execute([$user_id]);
            $row_count=$sql->rowCount();
            if ($row_count==0){
                return 0;
            }
            else{
                $r = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $dep_id=$sql->fetchAll();
                return $dep_id[0]['department_id'] ;
            }
        

}
function sec_login($user_id){
            global $conn;
            $fetch_query = "SELECT Section_id, department_id FROM [Section] WHERE user_id = ?";
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $conn->prepare($fetch_query);
            $sql->execute([$user_id]);
            $row_count = $sql->rowCount();

            if ($row_count==0){
                return 0;
            }
            else{
                $r = $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sec_id=$sql->fetchAll();

                return $sec_id[0];
            }
}
$con= null;
?>

