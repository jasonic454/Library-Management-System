<?php
/**
* This file contains the CustomerBorrowHistory Class
*
*/

/**
 * CustomerBorrowHistory is an extended PanelModel Class
 *
 * The purpose of this class is to generate HTML view panel headings and content
 * for a CUSTOMER - Borrow History page. Customers can view their borrow history
 * and return books that are still marked as Borrowed.
 *
 * @author K00267870
 */
class CustomerBorrowHistory extends PanelModel {

    protected $statusMessage = '';

    /**
     * Constructor Method
     *
     * @param User $user The current user
     * @param MySQLi $db The database connection handle
     * @param Array $postArray Copy of the $_POST array
     * @param String $pageTitle The page Title
     * @param String $pageHead The Page Heading
     * @param String $pageID The currently selected Page ID
     */
    function __construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID){
        $this->modelType='CustomerBorrowHistory';
        //handle return book button
        if(isset($postArray['btnReturnBook']) && isset($postArray['borrow_id'])){
            $bookTable = new BookTable($db);
            if($bookTable->returnBook((integer)$postArray['borrow_id'], $user->getUserID())){
                $this->statusMessage = '<p class="text-success">Book returned successfully.</p>';
            }
            else{
                $this->statusMessage = '<p class="text-danger">Unable to return book. Please try again.</p>';
            }
        }
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    }


    /**
     * Set the Panel 1 heading
     */
    public function setPanelHead_1(){
        $this->panelHead_1 = '<h3>My Borrowing History</h3>';
    }


    /**
     * Set the Panel 1 text content - borrow history table with return buttons
     */
    public function setPanelContent_1(){

        if($this->statusMessage !== ''){
            $this->panelContent_1 = $this->statusMessage;
        }

        $bookTable = new BookTable($this->db);
        $rs = $bookTable->getBorrowHistoryByUser($this->user->getUserID());

        if($rs && $rs->num_rows > 0){
            $html  = '<div class="table-responsive-wrapper">';
            $html .= '<table class="table table-striped">';
            $html .= '<tr>';
            $html .= '<th>Borrow ID</th><th>Title</th><th>Author</th>';
            $html .= '<th>Borrow Date</th><th>Return Date</th><th>Status</th><th>Action</th>';
            $html .= '</tr>';

            while($row = $rs->fetch_assoc()){
                $html .= '<tr>';
                $html .= '<td>'.(integer)$row['borrow_id'].'</td>';
                $html .= '<td>'.htmlspecialchars($row['title']).'</td>';
                $html .= '<td>'.htmlspecialchars($row['author']).'</td>';
                $html .= '<td>'.htmlspecialchars($row['borrow_date']).'</td>';
                $html .= '<td>'.($row['return_date'] ? htmlspecialchars($row['return_date']) : '-').'</td>';
                $html .= '<td>'.htmlspecialchars($row['status']).'</td>';
                $html .= '<td>';
                if($row['status'] === 'Borrowed'){
                    $html .= '<form method="post" action="index.php?pageID=borrowHistory">';
                    $html .= '<input type="hidden" name="borrow_id" value="'.(integer)$row['borrow_id'].'">';
                    $html .= '<button type="submit" class="btn btn-danger btn-xs" name="btnReturnBook" value="return">Return</button>';
                    $html .= '</form>';
                }
                else{
                    $html .= '<span class="label label-default">Returned</span>';
                }
                $html .= '</td>';
                $html .= '</tr>';
            }

            $html .= '</table></div>';
            $this->panelContent_1 .= $html;
        }
        else{
            $this->panelContent_1 .= '<p>You have no borrowing history yet.</p>';
        }
    }


    /**
     * Set the Panel 2 heading
     */
    public function setPanelHead_2(){
        $this->panelHead_2 = '<h3>Member Summary</h3>';
    }


    /**
     * Set the Panel 2 text content
     */
    public function setPanelContent_2(){
        $this->panelContent_2  = '<p><strong>Name:</strong> '.htmlspecialchars($this->user->getUserFirstName().' '.$this->user->getUserLastName()).'</p>';
        $this->panelContent_2 .= '<p><strong>Login ID:</strong> '.htmlspecialchars($this->user->getUserID()).'</p>';
        $this->panelContent_2 .= '<p>This page shows all books you have borrowed. Click <strong>Return</strong> on any active borrow to return the book.</p>';
    }


    /**
     * Set the Panel 3 heading
     */
    public function setPanelHead_3(){
        $this->panelHead_3 = '<h3>Navigation</h3>';
    }


    /**
     * Set the Panel 3 text content
     */
    public function setPanelContent_3(){
        $this->panelContent_3  = '<ul>';
        $this->panelContent_3 .= '<li><a href="index.php?pageID=viewBooks">Browse Books</a></li>';
        $this->panelContent_3 .= '<li><a href="index.php?pageID=home">Home</a></li>';
        $this->panelContent_3 .= '</ul>';
    }

}
