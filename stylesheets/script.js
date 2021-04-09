document.addEventListener('DOMContentLoaded', function() {
    if( document.querySelector('.plus')!=null){
    document.querySelector('.plus').onclick = function(){
        let table_row = document.createElement('tr')
        table_row.innerHTML = `<tr>
        <td>
            <input type="Date" class="form-control" name="date[]">
        </td>
        <td>
             <textarea style="text-align: left;" class="form-control" rows="1" name="description[]" placeholder="enter description"></textarea>
        </td>
        <td text-center>
            <input type="number" class="form-control" name="amount[]" placeholder="Enter amount">
        </td>
    </tr>`;
    let table = document.querySelector('.table').querySelector('tbody');
    table.append(table_row);
    document.querySelector('.form-submit').disabled = false;
    return false;
    }
}

if( document.querySelector('.minus')!=null){
    document.querySelector('.minus').onclick = function(){
        let table_last_row = document.querySelector('.table').querySelector('tbody').lastElementChild;
        if(table_last_row!=null){
        table_last_row.remove();
        }
        if(document.querySelector('.table').querySelector('tbody').lastElementChild==null){
            document.querySelector('.form-submit').disabled = true;
        }
        return false;
    }
}

    /*
    $(".clickable-row").click(function() {

        $.post("../src/list.php",{
            form_id: `${$(this).find(".form_id").val()}`
        },
        function(result) {console.log(result)});
    });
    */
    /*
    document.querySelectorAll('.clickable-row').forEach(element => {
        element.onclick = function(){
        console.log(this.querySelector('.form_id').value);
        fetch('../src/list.php', {
        method: 'POST',
        body: ({
            form_id: `${this.querySelector('.form_id').value}`
        }),
      })
      .then(response => {
          console.log(response.body);
        return response.json();
      })   
    }}); 
    */
    if(document.querySelectorAll('.clickable-row')!=null){
    document.querySelectorAll('.clickable-row').forEach(element => {
        element.onclick = function(){
            let form_id = this.querySelector('.form_id').value;
            window.location = `./fixed_form.php?form_id=${form_id}`;
        }})
    }
    /*
    if(document.querySelectorAll('.clickable-row')!=null){
        document.querySelectorAll('.clickable-row').onclick = function(){
                let form_id = this.querySelector('.form_id').value;
                window.location = `http://localhost:8080/dashboard/ERP-project/src/fixed_form.php?form_id=${form_id}`;
            }   
        }
    */

    
    if(document.querySelector('.btn-lg')!=null){
        document.querySelectorAll('.btn-lg').forEach(element => {
            element.onclick = function(){
                if(element.innerHTML==='Approve'){
                    let dialog_body = document.querySelector('.modal-body')
                    dialog_body.innerHTML = "Are you sure you want to Accept the Expense Proposal?";
                    let dialog_footer = document.querySelector('.modal-footer');
                    let button = dialog_footer.querySelector('.btn-danger');
                    button.className = 'btn btn-primary accept';
                    button.innerHTML = 'Approve';
                }
                else{
                    let dialog_body = document.querySelector('.modal-body')
                    dialog_body.innerHTML = "Are you sure you want to Decline the Expense Proposal?";
                    let dialog_footer = document.querySelector('.modal-footer');
                    let button = dialog_footer.querySelector('.btn-primary');
                    button.className = 'btn btn-danger decline';
                    button.innerHTML = 'Decline';
                }
        
            }})
        }


            document.addEventListener('click',function(e){
                
                if( e.srcElement.className === 'btn btn-danger decline' ){
                    let form_id = document.querySelector('.form_id').value;
                    window.location = `./accounts_check.php?form_id=${form_id}&status=decline`;
                }
                else if(e.srcElement.className === 'btn btn-primary accept'){
                    console.log("hello");
                    let form_id = document.querySelector('.form_id').value;
                    window.location = `./accounts_check.php?form_id=${form_id}&status=active`;
                }
            })
        }
        


    
        
    



)