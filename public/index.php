<?php

require_once '../src/twig.php';
require_once '../src/db_conn.php';


session_start();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = NULL;
    if (isset($_SESSION['user_id'])) {
        echo $twig->render('hello.html.twig', array(
            'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"], 'department_id'=>$_SESSION["department_id"]
        ));
        return;
    } else {
        echo $twig->render('login.html.twig', array());
        return;
    }
}
elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ( isset( $_POST['login'] ) ) {

        $emp_id = $_POST['username'];
        $password = $_POST['password'];

        $sql1 = $conn->prepare("Select * from Login_credentials where emp_id=?");
        $sql1->execute(array($emp_id));
        $employee = $sql1->fetchAll();

        if(count($employee)!=1){
            echo $twig->render('login.html.twig', array(
                'error' => 'Employee_id or password incorrect',
                ));
                return;
        }
            
            if(password_verify($password, $employee[0]["password"])===true){
                /*
                $cookie_name = "user";
                $cookie_value = $emp_id;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
                */
                
                
                $sql2 = $conn->prepare("Select Employee.emp_id,Employee.Job_id,Employee.Department_id,Employee.First_name from Employee inner join Jobs on Employee.Job_id=Jobs.Job_id where emp_id=?");
                $sql2->execute(array($emp_id));
                $employee2 = $sql2->fetchAll();

                if(count($employee2)!=1){
                    echo $twig->render('login.html.twig', array(
                        'error' => 'Employee_id or password incorrect',
                        ));
                        return;
                }
                
                $_SESSION["user_id"] = $emp_id;
                    /*
                    $cookie_name = "job";
                    $cookie_value = $row2['Job_id'];
                    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
                    */
                    $Job_id = $employee2[0]['Job_id'];
                    $name = $employee2[0]['First_name'];
                    $department_id = $employee2[0]['Department_id'];
                    $_SESSION["job_id"] = $Job_id;
                    $_SESSION["name"] =  $name;
                    $_SESSION["department_id"] = $department_id;
                    
                        echo $twig->render('hello.html.twig', array(
                            'authenticated' => true, 'name'=>$name, 'Job' => $Job_id, 'department_id'=>$department_id
                        ));
                        return;
                
            }
            else{
             echo $twig->render('login.html.twig', array(
                    'error' => 'Employee_id or password incorrect',
                ));
                return;
            }
        
    }
    echo $twig->render('login.html.twig', array(
        'error' => 'Employee_id or password incorrect',
        ));
        return;
}
?>