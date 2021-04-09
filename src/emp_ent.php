<?php
require_once './twig.php';
require_once './db_conn.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_SESSION['user_id'])) {
        
        if($_SESSION['department_id']==2){
        
            $sql1 = $conn->prepare("SELECT emp_id,Form_id, time, Total_amount From Expense_entry");
            $sql1->execute();
            $sql1 = $sql1->fetchAll();

            $total = 0;
            foreach($sql1 as $expenses){
                $total = $total + $expenses['Total_amount'];
            }

            
            echo $twig->render('emp_ent.html.twig', array(
                'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"], 'data'=> $sql1, 'department_id'=>$_SESSION["department_id"], 'Total'=>$total
            ));
            return;
        }
    } 
}

header("Location: ../public/index.php");
        return;


?>