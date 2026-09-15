<?php
/**
* This file contains the Form Class
* 
*/

/**
 * 
 * Form class - is a helper class that generates HTML forms  
 * 
 *  
 * @author Gerry Guinane
 * 
 */

class Form {


/**
 * Generates a HTML user select form 
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form. 
 * @return string String containing the generated form.
 */    
public static function form_select_user($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="userID">User ID (email)</label><input required type="text" class="form-control" id="userID" name="userID" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnUserSelect">Select</button>';
        $form.='</form>';
        return $form;
}    
    
    
    
/**
 * Generates a HTML login form 
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form. 
 * @return string String containing the generated form.
 */    
public static function form_login($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="userID">ID (email)</label><input required type="text" class="form-control" id="userID" name="userID" >';
        $form.='<label for="password">Password</label><input required type="password" class="form-control" id="password" name="password" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnLogin">Login</button>';
        $form.='</form>';
        return $form;
}    

/**
 * Generates a HTML password change form
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */
public static function form_password_change($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="pass1">Enter New Password</label><input required type="password" class="form-control" id="pass1" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">';
        $form.='<label for="pass2">Re-enter New Password</label><input required type="password" class="form-control" id="pass2" name="pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">';
        $form.='<label for="password">Enter OLD Password</label><input required type="password" class="form-control" id="password" name="password" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnChangePW">Change Password</button>';
        $form.='<button type="submit" class="btn btn-default" name="btnCancelUpdatePW" value="updatePWCancel">Cancel</button>';
        $form.='</form>';
        return $form;
} 

/**
 * 
 * Generates a HTML form for editing account details. 
 * 
 * The form generated will display but does not permit editing of the users ID.  
 * 
 * @param CountyTable $countyTable A county table entity object.
 * @param mysqli_result $userRecord Resultset containing the current user details from the database  user table 
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */
public static function form_edit_account($countyTable,$userRecord, $pageID){
        $countyList=array();
        $i=1;  //array index
        if($rs=$countyTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $countyList[$row['idcounty']]=$row['countyName'];   //build an array of county names $countyList
                $i++;
            }
        } 
        
        $userRecordArray=$userRecord->fetch_assoc();
        extract($userRecordArray); //makes constructing the form a little easier
        
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
       
        $form.='<label for="firstName">First Name</label><input required type="text" class="form-control"  value="'.$FirstName.'" id="firstName" name="firstName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="First Name (up to 45 Characters)">';
        $form.='<label for="lastName">Last Name</label><input required type="text" class="form-control"   value="'.$LastName.'" id="lastName" name="lastName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="Last Name (up to 45 Characters)" >';
        $form.='<label for="idCounty">county</label>';
        $form.='<select class="form-control" id="idCounty" name="idCounty">';
          $form.= '<option value="'.$idcounty.'">'.$countyList[$idcounty].'</option>'; //the displayed value should be the current value in database
          foreach($countyList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';  //drop down list of all counties
          }
        $form.='</select>';
        
        //hidden DEFAULT input values for user type and login enabled
        $form.= '<input type="hidden" id="userTypeNr" name="userTypeNr" value="'.$userTypeNr.'">'; //default user type is customer
        $form.= '<input type="hidden" id="userEnabled" name="userEnabled" value="1">'; //default enabled to login is true        
        
        $form.='<label for="email">email (not editable)</label><input required readonly type="text" class="form-control" value="'.$email.'" id="email" name="email" pattern="[a-zA-Z0-9@.]{1,45}" title="enter a valid email" >';
        $form.='<label for="mobile">mobile</label><input type="text" class="form-control" value="'.$mobile.'" id="mobile" name="mobile" pattern="[0-9()+-\']{7,20}" title="enter a valid phone number" >';

        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" name="btnUpdateAccount" value="update">Update</button>';
        $form.='<button type="submit" class="btn btn-default" name="btnCancelUpdateAccount" value="update">Cancel Update</button>';
        $form.='</form>';
        
        return $form;
    }


/**
 * 
 * Generates a HTML form for editing account details. 
 * 
 * The form generated will display but does not permit editing of the users ID.  
 * 
 * @param CountyTable $countyTable A county table entity object.
 * @param UserTypeTable $userTypeTable A county table entity object.
 * @param mysqli_result $userRecord Resultset containing the current user details from the database  user table 
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */
public static function form_administrator_edit_account($countyTable,$userTypeTable,$userRecord, $pageID){
    
    
        $countyList=array();
        $i=1;  //array index
        if($rs=$countyTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $countyList[$row['idcounty']]=$row['countyName'];   //build an array of county names $countyList
                $i++;
            }
        } 
        
        $userTypeList=array();
        if($rs=$userTypeTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $userTypeList[$row['userTypeNr']]=$row['userTypeDescr'];   //build an array of county names $countyList
            }
        } 
        
        
        $userRecordArray=$userRecord->fetch_assoc();
        extract($userRecordArray); 
        
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="userID">User ID (not editable)</label><input required readonly type="text" class="form-control"   value="'.$userID.'" id="userID" name="userID" >';
        $form.='<label for="firstName">First Name</label><input required type="text" class="form-control"  value="'.$FirstName.'" id="firstName" name="firstName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="First Name (up to 45 Characters)">';
        $form.='<label for="lastName">Last Name</label><input required type="text" class="form-control"   value="'.$LastName.'" id="lastName" name="lastName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="Last Name (up to 45 Characters)" >';

        $form.='<label for="idCounty">County</label>';
        $form.='<select class="form-control" id="idCounty" name="idCounty">';
          $form.= '<option value="'.$idcounty.'">'.$countyList[$idcounty].'</option>'; //the displayed value should be the current value in database
          foreach($countyList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';  //drop down list of all counties
          }
        $form.='</select>';


        $form.='<label for="userTypeNr">Select Usertype</label>';
        $form.='<select class="form-control" id="userTypeNr" name="userTypeNr">';
              $form.= '<option value="'.$userTypeNr.'" selected>'.$userTypeDescr.'</option>';
          foreach($userTypeList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';  
          }
        $form.='</select>';


        $form.='<label for="userEnabled">Enable/Disable User Access</label>';
        $form.='<select class="form-control" id="userEnabled" name="userEnabled">';
              if($userEnabled){
                  $form.= '<option value="1">LOGIN ENABLED</option>';  
                  $form.= '<option value="0">DISABLE LOGIN</option>'; 
              }
              else{
                  $form.= '<option value="0">LOGIN NOT ENABLED</option>';  
                  $form.= '<option value="1">ENABLE LOGIN</option>'; 
              }
        $form.='</select>';
        

        $form.='<label for="email">email (not editable)</label><input required readonly type="text" class="form-control" value="'.$email.'" id="email" name="email" pattern="[a-zA-Z0-9@.]{1,45}" title="enter a valid email" >';
        $form.='<label for="mobile">mobile</label><input type="text" class="form-control" value="'.$mobile.'" id="mobile" name="mobile" pattern="[0-9()+-\']{7,20}" title="enter a valid phone number" >';

        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" name="btnUpdateAccount" value="update">Update</button>';
        $form.='<button type="submit" class="btn btn-default" name="btnCancelUpdateAccount" value="update">Cancel Update</button>';
        $form.='</form>';
        
        return $form;
    }

    
    
/**
 * Generates a HTML form for registering a new  account.  It is intended for administrator use
 * 
 * The form generated will display a drop down list/chooser of counties and user types.  
 * 
 * @param CountyTable $countyTable A county table entity object.
 * @param UserTypeTable $userTypeTable A county table entity object.
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */
public static function form_register($countyTable,$userTypeTable, $pageID){
        $countyList=array();
        if($rs=$countyTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $countyList[$row['idcounty']]=$row['countyName'];   //build an array of county names $countyList
            }
        } 
        
        $userTypeList=array();
        if($rs=$userTypeTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $userTypeList[$row['userTypeNr']]=$row['userTypeDescr'];   //build an array of county names $countyList
            }
        } 
        
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="firstName">First Name</label><input required type="text" class="form-control" id="firstName" name="firstName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="First Name (up to 45 Characters)">';
        $form.='<label for="lastName">Last Name</label><input required type="text" class="form-control" id="lastName" name="lastName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="Last Name (up to 45 Characters)" >';

        $form.='<label for="idCounty">County (select your county)</label>';
        $form.='<select class="form-control" id="idCounty" name="idCounty">';
              $form.= '<option value="99" selected>Select a County</option>';
          foreach($countyList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';  
          }
        $form.='</select>';

        $form.='<label for="userTypeNr">Select Usertype</label>';
        $form.='<select class="form-control" id="userTypeNr" name="userTypeNr">';
              $form.= '<option value="99" selected>Select a User Type</option>';
          foreach($userTypeList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';  
          }
        $form.='</select>';

        $form.='<label for="userEnabled">Enable/Disable User Access</label>';
        $form.='<select class="form-control" id="userEnabled" name="userEnabled">';
                  $form.= '<option value="1" selected>LOGIN ENABLED(DEFAULT)</option>';  
                  $form.= '<option value="0">LOGIN NOT ENABLED </option>';  
                  $form.= '<option value="1">ENABLE LOGIN</option>'; 
        $form.='</select>';

        $form.='<label for="email">email (this will be your user ID) </label><input type="text" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9@.]{1,45}" title="enter a valid email" >';
        $form.='<label for="mobile">mobile</label><input type="text" class="form-control" id="mobile" name="mobile" pattern="[0-9()+-\']{7,20}" title="enter a valid phone number" >';
        $form.='<label for="pass1">Password</label><input required type="password" class="form-control" id="pass1" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">';
        $form.='<label for="pass2">Re-enterPassword</label><input required type="password" class="form-control" id="pass2" name="pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" name="btnRegister" value="registerUser">Register</button>';
        $form.='</form>';
        
        return $form;
    }
    

  
/**
 * Generates a HTML form for registering a new  account.  It is intended for CUSTOMER use
 * 
 * The form generated will display a drop down list/chooser of counties and user types.  
 * 
 * @param CountyTable $countyTable A county table entity object.
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */
public static function form_register_customer($countyTable,$pageID){
        $countyList=array();
        if($rs=$countyTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $countyList[$row['idcounty']]=$row['countyName'];   //build an array of county names $countyList
            }
        } 
        

        
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="firstName">First Name</label><input required type="text" class="form-control" id="firstName" name="firstName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="First Name (up to 45 Characters)">';
        $form.='<label for="lastName">Last Name</label><input required type="text" class="form-control" id="lastName" name="lastName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="Last Name (up to 45 Characters)" >';

        $form.='<label for="idCounty">County (select your county)</label>';
        $form.='<select class="form-control" id="idCounty" name="idCounty">';
              $form.= '<option value="99" selected>Select a County</option>';
          foreach($countyList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';  
          }
        $form.='</select>';

        //hidden DEFAULT input values for user type and login enabled
        $form.= '<input type="hidden" id="userTypeNr" name="userTypeNr" value="3">'; //default user type is customer
        $form.= '<input type="hidden" id="userEnabled" name="userEnabled" value="1">'; //default enabled to login is true


        $form.='<label for="email">email (this will be your user ID) </label><input type="text" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9@.]{1,45}" title="enter a valid email" >';
        $form.='<label for="mobile">mobile</label><input type="text" class="form-control" id="mobile" name="mobile" pattern="[0-9()+-\']{7,20}" title="enter a valid phone number" >';
        $form.='<label for="pass1">Password</label><input required type="password" class="form-control" id="pass1" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">';
        $form.='<label for="pass2">Re-enterPassword</label><input required type="password" class="form-control" id="pass2" name="pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" name="btnRegister" value="registerUser">Register</button>';
        $form.='</form>';
        
        return $form;
    }
        
    
    
/**
 * Generates a HTML form for entering a chat message and optionally specifying a recipient. 
 * 
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */    
public static function form_add_msg($pageID){
        $form='<div class="container-fluid">';
        $form.='<form method="post" action="index.php?pageID='.$pageID.'">';

        $form.='<div class="form-group">';
        
        $form.='<label for="message">Enter a Message</label><textarea class="form-control" id="message" name="message" rows="3" style="resize:vertical"></textarea> ';
                
        $form.='<label for="msgTo">Addressed To (enter ID or leave blank for ALL)</label><input type="text" class="form-control" id="msgTo" name="msgTo" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnAddMsg">Submit Message</button>';
        $form.='</form>';
        $form.='</div>';
        return $form;
}      

    
/**
 * Generates a HTML CONFIRM form (Button)
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form. 
 * @param string $choice The value of the chosen variable to be confirmed. 
 * @param string $btnText The text to appear on the form button. 
 * @return string String containing the generated form.
 */    
public static function form_confirm($pageID,$btnText,$choice){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<button type="submit" class="btn btn-default" value='.$choice.' name="btnConfirm">'.$btnText.'</button>';
        $form.='<button type="submit" class="btn btn-default" value='.FALSE.' name="btnConfirm">CANCEL</button>';
        $form.='</form>';
        return $form;
}    
   




/**
 * Generates a HTML form for adding a new book.
 *
 * @param CategoryTable $categoryTable
 * @param string $pageID
 * @return string
 */
public static function form_add_book($categoryTable,$pageID){
        $categoryList=array();
        if($rs=$categoryTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $categoryList[$row['category_id']]=$row['category_name'];
            }
        }

        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="title">Title</label><input required type="text" class="form-control" id="title" name="title" maxlength="100">';
        $form.='<label for="author">Author</label><input required type="text" class="form-control" id="author" name="author" maxlength="100">';
        $form.='<label for="isbn">ISBN</label><input required type="text" class="form-control" id="isbn" name="isbn" maxlength="20">';
        $form.='<label for="category_id">Category</label>';
        $form.='<select class="form-control" id="category_id" name="category_id">';
        foreach($categoryList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';
        }
        $form.='</select>';
        $form.='<label for="quantity">Total Quantity</label><input required type="number" min="0" class="form-control" id="quantity" name="quantity" value="1">';
        $form.='<label for="available_quantity">Available Quantity</label><input required type="number" min="0" class="form-control" id="available_quantity" name="available_quantity" value="1">';
        $form.='</div>';
        $form.='<button type="submit" class="btn btn-default" name="btnAddBook" value="addBook">Add Book</button>';
        $form.='</form>';
        return $form;
}

/**
 * Generates a HTML form for editing a book record.
 *
 * @param CategoryTable $categoryTable
 * @param mysqli_result $bookRecord
 * @param string $pageID
 * @return string
 */
public static function form_edit_book($categoryTable,$bookRecord,$pageID){
        $categoryList=array();
        if($rs=$categoryTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $categoryList[$row['category_id']]=$row['category_name'];
            }
        }

        $book=$bookRecord->fetch_assoc();
        extract($book);

        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<input type="hidden" id="book_id" name="book_id" value="'.$book_id.'">';
        $form.='<label for="title">Title</label><input required type="text" class="form-control" id="title" name="title" value="'.$title.'" maxlength="100">';
        $form.='<label for="author">Author</label><input required type="text" class="form-control" id="author" name="author" value="'.$author.'" maxlength="100">';
        $form.='<label for="isbn">ISBN</label><input required type="text" class="form-control" id="isbn" name="isbn" value="'.$isbn.'" maxlength="20">';
        $form.='<label for="category_id">Category</label>';
        $form.='<select class="form-control" id="category_id" name="category_id">';
        foreach($categoryList as $key=>$value){
              $selected = ($key==$category_id) ? ' selected' : '';
              $form.= '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
        }
        $form.='</select>';
        $form.='<label for="quantity">Total Quantity</label><input required type="number" min="0" class="form-control" id="quantity" name="quantity" value="'.$quantity.'">';
        $form.='<label for="available_quantity">Available Quantity</label><input required type="number" min="0" class="form-control" id="available_quantity" name="available_quantity" value="'.$available_quantity.'">';
        $form.='</div>';
        $form.='<button type="submit" class="btn btn-default" name="btnUpdateBook" value="updateBook">Update Book</button>';
        $form.='</form>';
        return $form;
}

}
