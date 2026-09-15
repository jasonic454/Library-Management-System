<?php
/**
* This file contains the HelperHTML Base Class. 
* 
*/

/**
 * 
 * HelperHTML class provides static HTML helper functions. 
 * 
 * @author Gerry Guinane
 * 
 */
Class HelperHTML {
    
    
    
   /**
    * Function that generates a HTML table from a resultset object. 
    * 
    * @param mysqli_result  $resultSet A resultset object
    * @return string Containing a HTML table corresponding to the resultset. 
    * 
    */
    public static function generateTABLE($resultSet){
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $table='';  //start with an empty string
        
        if($resultSet){ //check that a valid resultset has been passed to this method
        
        //generate the HTML table
        $i=0;
        $resultSet->data_seek(0);  //point to the first row in the result set
        $table.= '<table class="table table-striped">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            while ($i===0)  //trick to generate the HTML table headings
            {   $table.=  '<tr>';
                foreach($row as $key=>$value){
                    $table.=  "<th>$key</th>"; //echo the keys as table headings for the first row of the HTML table
                }
                $table.=  '</tr>';
                $i=1;  
            }

            $table.=  '<tr>';
            foreach($row as $value){
                $table.=  "<td>$value</td>";
                }
            $table.=  '</tr>';
        }
        $table.=  '</table>';
        }
        else{
            $table='Sorry - there is no data available matching your query at this time';
        }
        return $table;
    }
    
    
       /**
    * Function that generates a HTML 2 column table from a single associative array. 
    * 
    * @param array  $dataArray An associative array of data (mixed)
    * @return string Containing a HTML table corresponding to the resultset. 
    * 
    */
    public static function generateVerticalRecordTable($dataArray){
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $dataArray which must contain an associative array of data

        
        $table= '<table class="table table-striped">';
        
        foreach($dataArray as $key=>$value){
            $table.= '<tr>';
            $table.= '<td><b>'.$key.'</b></td>';
            $table.= '<td>'.$value.'</td>';
            $table.= '</tr>';
         
        }
        $table.='</table>';          
        return $table;
    }
    
    
    
    /**
     * 
     * Function that generates a HTML string from a resultset object. Intended for use in conjunction with AJAX
     * 
     * @param mysqli_result $resultSet
     * @param string $userID
     * @return string Containing a HTML formatted string corresponding to the resultset.
     * 
     */
    public static function generateCHAT($resultSet,$userID){
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $text='<div class="container-fluid" style="background-color:lightgray">';  //set up the target div
        $text.=  "</br>";
        if($resultSet){ //check that a valid resultset has been passed to this method

        $resultSet->data_seek(0);  //point to the first row in the result set

        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            
            if($row['SenderID']===$userID){  //current user sent the message
                $from = '<b><font color="green">From Me :</font></b>' ;
                $to='<b><font color="gray">To:'.$row['Recipient'].'</font></b> ';
            }
            else if($row['Recipient']===$userID){ //current user is the intended resipient
                $to = '<b><font color="green">To:Me</font></b>' ;
                $from='<b><font color="red">'.$row['UserName'].'</font></b> ';
                }
            else{
                $to='<b><font color="gray">To All</font></b> ';
                $from=$row['UserName'];
            }
            $text.= '<font color="gray">'.$row['Sent'].'</font> ';
            
            $text.= $from;
            $text.= $to;
            $text.= '</br><font color="blue">'.$row['Message_Content'].'</em></font>';
            $text.=  "</br>";
            }
        }
        else{
            $text='No live chat data available at this time';
        }
        $text.=  "</br>";
        $text.='</div></div>';
        return $text;
    }    
    
    
    /**
     * Function that generates a HTML table with a SELECT button from a resultset object. 
     * 
     * @param mysqli_result $resultSet The resultset to be implemented in the select table. 
     * @param string $selectKeyField Specifies which table entity field should be used to uniquely identify a record. 
     * @param string $pageID The current page ID
     * @param string $buttonText Text to appear on the SELECT button
     * @return string String containing a HTML table with a SELECT button from a resultset object.
     */
    public static function generateSelectTABLE($resultSet,$selectKeyField,$pageID,$buttonText){
        //This STATIC method returns a HTML table as a string
        //It takes one argument - $resultSet which must contain an object
        //of the $resultSet class
        $table="";  //start with an empty string
        
        if($resultSet){ //check that a valid resultset has been passed to this method
        
        //generate the HTML table
        $i=0;
        $resultSet->data_seek(0);  //point to the first row in the result set
        $table.= '<table class="table table-striped">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            while ($i===0)  //trick to generate the HTML table headings
            {   $table.=  '<tr>';
                foreach($row as $key=>$value){
                    $table.=  "<th>$key</th>"; //echo the keys as table headings for the first row of the HTML table
                }
                $table.=  "<th>Select</th>";
                $table.=  '</tr>';
                $i=1;  
            }

            $table.=  '<tr>';
            foreach($row as $key=>$value){  //generate the data columns
                $table.=  "<td>$value</td>";
                }
                
            foreach($row as $key=>$value){ //generate the selector button with the hidden key value
                if ($key===$selectKeyField){
                    $table.=  "<td>";
                    $table.=  '<form action="index.php?pageID='.$pageID.'" method="post">';    
                    $table.=  '<input type="submit" type="button" value="'.$buttonText.'" name="btnRecordSelected">'; 
                    $table.=  '<input type="hidden" value="'.$value.'" name="recordSelected">'; 
                    $table.=  '</form>';    
                    $table.=  '</td>';
                }
                }                
                
                
                
            $table.=  '</tr>';
        }
        $table.=  '</table>';
        }
        else{
            $table='Sorry - there is no data available matching your query at this time';
        }
        return $table;
    }
    
    
    
    
    
    
    
}


