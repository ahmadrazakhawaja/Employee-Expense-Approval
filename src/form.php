<?php
require_once './twig.php';
require_once './db_conn.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $conn = NULL;
    if (isset($_SESSION['user_id'])) {
        echo $twig->render('form.html.twig', array(
            'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"],'department_id'=>$_SESSION["department_id"]
        ));
        return;
    } 
    header("Location: ../public/index.php");
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {

        $travel_date = $_POST['travel_date'];
        $return_date = $_POST['return_date'];
        $items_date = $_POST['date'];
        $items_desc = $_POST['description'];
        $items_amount = $_POST['amount'];
        $total = 0;
    
        if($items_date == null){
            echo $twig->render('form.html.twig', array(
                'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"],
                'error'=>"Please enter correct date."
            ));
            return;
        }
        if($items_desc == null){
            echo $twig->render('form.html.twig', array(
                'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"],
                'error'=>"Please enter correct description."
            ));
            return;
        }
        if($items_amount == null){
            echo $twig->render('form.html.twig', array(
                'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"],
                'error'=>"Please enter correct amount."
            ));
            return;
        }

        for($i = 0; $i < count($items_date); $i++){

            if($items_amount[$i]==null){
                echo $twig->render('form.html.twig', array(
                    'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"],
                    'error'=>"Please enter correct amount."
                ));
                return;
            }
            if($items_date[$i]==null){
                echo $twig->render('form.html.twig', array(
                    'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"],
                    'error'=>"Please enter correct date."
                ));
                return;
            }
            if($items_desc[$i]==null){
                echo $twig->render('form.html.twig', array(
                    'authenticated' => true, 'name'=>$_SESSION["name"], 'Job' => $_SESSION["job_id"],
                    'error'=>"Please enter correct description."
                ));
                return;
            }
            $total = $total + $items_amount[$i];
        }
        if($travel_date == null){
            $sql1 = $conn->prepare("INSERT INTO Expense_form(emp_id,Total,Status,Hod_status) VALUES(?,?,?,?)");
            $sql1->execute(array($_SESSION['user_id'],$total,2,$_SESSION['job_id'] == 123 ? 3 : 2 ));
        }
        else if($return_date == null){
            $sql1 = $conn->prepare("INSERT INTO Expense_form(emp_id,Total,Status,Hod_status) VALUES(?,?,?,?)");
            $sql1->execute(array($_SESSION['user_id'],$total,2,$_SESSION['job_id'] == 123 ? 3 : 2));
        }
        else{
            $sql1 = $conn->prepare("INSERT INTO Expense_form(emp_id,Travel_date,Return_date,Total,Status,Hod_status) VALUES(?,?,?,?,?,?)");
            $sql1->execute(array($_SESSION['user_id'],$travel_date,$return_date,$total,2,$_SESSION['job_id'] == 123 ? 3 : 2));
        }
        
        
        $sql2 = $conn->prepare("SELECT Form_id FROM Expense_form WHERE emp_id = ? ORDER BY submit_time DESC LIMIT 1");
        $sql2->execute(array($_SESSION['user_id']));
        $sql2 = $sql2->fetchAll();
        $form_id = $sql2[0]['Form_id'];
        
        for($i = 0; $i < count($items_date); $i++){
    
            $sql2 = $conn->prepare("INSERT into Expense_items(Form_id,Date,exp_name,amount) VALUES(?,?,?,?)");
            $sql2->execute(array($form_id,$items_date[$i],$items_desc[$i],$items_amount[$i]));
            
        }

        if($_SESSION['job_id']==123){
            header("Location: ./accounts_check.php?form_id=$form_id&hod=true");
            return;
        }
        

        header("Location: ./list.php?submit=true");
        return;
        
    } 
    
}

header("Location: ../public/index.php");
return;


?>