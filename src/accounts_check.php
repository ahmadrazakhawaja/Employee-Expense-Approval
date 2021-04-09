<?php
require_once './twig.php';
require_once './db_conn.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['user_id'])) {
        $form_id = $_GET['form_id'];
        if($_SESSION['job_id']==123){
            if($_GET['hod']=='true'){
                header("Location: ./hod_list.php?submit=true");
            }
            else if($_GET['status']=='active'){
                
                $sql1 = $conn->prepare("UPDATE Expense_form SET Hod_status=? WHERE Form_id=?");
                $sql1->execute(array(3,$form_id));
                
                header("Location: ./emp_list.php");
                
            }
            else{
                $sql1 = $conn->prepare("UPDATE Expense_form SET Hod_status=?, Status=? WHERE Form_id=?");
                $sql1->execute(array(1,1,$form_id));
                
                header("Location: ./emp_list.php");
                return;
                
            }
            
            $sql1 = $conn->prepare("SELECT MAX(Date) FROM Expense_items WHERE Form_id=?");
            $sql1->execute(array($form_id));
            $sql1 = $sql1->fetchAll();
            if(count($sql1)==1){
            $date = $sql1[0]['MAX(Date)'];
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            }
            /*
            $sql2 = $conn->prepare("SELECT amount FROM Expense_items WHERE Form_id=?");
            $sql2->execute(array($form_id));
            $sql2 = $sql2->fetchAll();
            */
            $sql3 = $conn->prepare("SELECT Employee.emp_id,Expense_form.Total,Employee.Job_id FROM Expense_form INNER JOIN Employee ON Employee.emp_id=Expense_form.emp_id WHERE Form_id=?");
            $sql3->execute(array($form_id));
            $sql3 = $sql3->fetchAll();
            

            $sql4 = $conn->prepare("SELECT Monthly_budget FROM Budget WHERE Job_id=?");
            $sql4->execute(array($sql3[0]['Job_id']));
            $sql4 = $sql4->fetchAll();
            $budjet = $sql4[0]['Monthly_budget'];

            // need to add year and month here
            $total_month = 0;
            if(count($sql1)==1){
            $sql5 = $conn->prepare("SELECT Total_amount FROM Expense_entry WHERE emp_id=? AND MONTH(time)=? AND YEAR(TIME)=?");
            $sql5->execute(array($sql3[0]['emp_id'],$month,$year));
            $sql5 = $sql5->fetchAll();
            
            for($i = 0; $i < count($sql5); $i++){
                $total_month = $total_month + $sql5[$i]['Total_amount'];
            }
        }
            $total_month = $total_month + $sql3[0]['Total'];
            if($total_month<=$budjet){
                $sql1 = $conn->prepare("UPDATE Expense_form SET Status=? WHERE Form_id=?");
                $sql1->execute(array(3,$form_id));

                $sql1 = $conn->prepare("INSERT INTO Expense_entry(emp_id,Total_amount,Form_id) VALUES(?,?,?)");
                $sql1->execute(array($sql3[0]['emp_id'],$sql3[0]['Total'],$form_id));

            }
            else{
                $sql1 = $conn->prepare("UPDATE Expense_form SET Status=? WHERE Form_id=?");
                $sql1->execute(array(1,$form_id));
            }

            
            return;


        }
    } 
}

header("Location: ../public/index.php");
        return;


?>