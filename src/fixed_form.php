<?php
require_once './twig.php';
require_once './db_conn.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['user_id'])) {
        $form_id = $_GET['form_id'];
        
        //$sql1 = $conn->prepare("SELECT * FROM Expense_form WHERE Form_id=?");
        $sql1 = $conn->prepare("SELECT Employee.emp_id,Travel_date,Return_date,Department_id FROM Expense_form INNER JOIN Employee ON Employee.emp_id=Expense_form.emp_id WHERE Form_id=?");
        $sql1->execute(array($form_id));
        $sql1 = $sql1->fetchAll();
        
        if($_SESSION["user_id"]!=$sql1[0]['emp_id']){
            
        
        if(($_SESSION['job_id']==123 && $_SESSION['department_id']==$sql1[0]['Department_id']) || $_SESSION['department_id']==2){
            
            $sql1 = $conn->prepare("SELECT Employee.emp_id, Employee.First_name,Employee.Last_name, Jobs.Job_title, Expense_form.Total, Expense_form.Return_date, Expense_form.Travel_date, Expense_form.Hod_status FROM Expense_form INNER JOIN Employee ON Employee.emp_id=Expense_form.emp_id INNER JOIN Jobs ON Employee.Job_id=Jobs.Job_id  WHERE Expense_form.Form_id=?");
            $sql1->execute(array($form_id));
            $sql1 = $sql1->fetchAll();
            
            $sql2 = $conn->prepare("SELECT * FROM Expense_items WHERE Form_id=?");
            $sql2->execute(array($form_id));
            $sql2 = $sql2->fetchAll();
            
            if(count($sql1)!=1){
                header("Location: ./emp_list.php");
            }
            
            echo $twig->render('fixed_form.html.twig', array(
                'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"], 'data'=> $sql2, 'form_data'=>$sql1, 'travel_date'=>$sql1[0]['Travel_date'], 'return_date'=>$sql1[0]['Return_date'], 'form_id'=>$form_id, 'department_id'=>$_SESSION['department_id']
            ));
            return;
    
        }
        header("Location: ../public/index.php");
        return;
        }
        

        if(count($sql1)!=1){
            header("Location: ./list.php");
        }

        $sql2 = $conn->prepare("SELECT * FROM Expense_items WHERE Form_id=?");
        $sql2->execute(array((int)$form_id));
        $sql2 = $sql2->fetchAll();

        echo $twig->render('fixed_form.html.twig', array(
            'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"], 'data'=> $sql2, 'travel_date'=>$sql1[0]['Travel_date'],'return_date'=>$sql1[0]['Return_date'],'department_id'=>$_SESSION['department_id'],'normal'=>true
        ));
        
        return;
    } 
}
header("Location: ../public/index.php");
        return;


?>