<?php
require_once './twig.php';
require_once './db_conn.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['user_id']) && $_SESSION['job_id']!=123) {

        $sql1 = $conn->prepare("SELECT * FROM Expense_form WHERE emp_id=?");
        $sql1->execute(array($_SESSION['user_id']));
        $sql1 = $sql1->fetchAll();

        if($_GET['submit']!=null){
            if($_GET['submit']=='true'){
                echo $twig->render('list.html.twig', array(
                    'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"], 'data'=> $sql1,'department_id'=>$_SESSION["department_id"],
                    'submit_alert' => true
                ));
                return;
            }
        }
        echo $twig->render('list.html.twig', array(
            'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"], 'data'=> $sql1,'department_id'=>$_SESSION["department_id"]
        ));
        return;
    } 
}

header("Location: ../public/index.php");
return;


?>