<?php
require_once './twig.php';
require_once './db_conn.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_SESSION['user_id'])) {
        
        if($_SESSION['job_id']==123){
        
            $sql1 = $conn->prepare("SELECT Employee.emp_id, Employee.First_name,Employee.Last_name, Jobs.Job_title, Expense_form.Hod_status, Expense_form.Total,Expense_form.Form_id,Expense_form.submit_time FROM Expense_form INNER JOIN Employee ON Employee.emp_id=Expense_form.emp_id INNER JOIN Jobs ON Employee.Job_id=Jobs.Job_id  WHERE Employee.Department_id=? AND Employee.Job_id!=? ORDER BY Expense_form.submit_time DESC");
            $sql1->execute(array($_SESSION['department_id'],$_SESSION["job_id"]));
            $sql1 = $sql1->fetchAll();

            
            echo $twig->render('list.html.twig', array(
                'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"], 'data'=> $sql1,'department_id'=>$_SESSION["department_id"]
            ));
            return;
        }
    } 
}

header("Location: ../public/index.php");
        return;


?>