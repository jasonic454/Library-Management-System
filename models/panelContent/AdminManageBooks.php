<?php
/**
 * AdminManageBooks is an extended PanelModel Class
 */
class AdminManageBooks extends PanelModel {

    function __construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID) {
        $this->modelType = 'AdminManageBooks';
        parent::__construct($user, $db, $postArray, $pageTitle, $pageHead, $pageID);
    }

    public function setPanelHead_1() {
        switch ($this->pageID) {
            case 'viewBooks':
                $this->panelHead_1 = '<h3>Book List</h3>';
                break;
            case 'addBook':
                $this->panelHead_1 = '<h3>Add New Book</h3>';
                break;
            case 'editBook':
                $this->panelHead_1 = '<h3>Select Book To Edit</h3>';
                break;
            case 'deleteBook':
                $this->panelHead_1 = '<h3>Select Book To Delete</h3>';
                break;
            case 'viewBorrowedBooks':
                $this->panelHead_1 = '<h3>Borrowed Books</h3>';
                break;
            default:
                $this->panelHead_1 = '<h3>Manage Books</h3>';
                break;
        }
    }

    public function setPanelContent_1() {
        $bookTable = new BookTable($this->db);
        switch ($this->pageID) {
          case 'viewBooks':
    $this->panelContent_1 = '<div style="overflow-x:auto;">'
        . HelperHTML::generateTABLE($bookTable->getAllBooks())
        . '</div>';
    break;
            case 'addBook':
                $categoryTable = new CategoryTable($this->db);
                $this->panelContent_1 = Form::form_add_book($categoryTable, $this->pageID);
                break;
           case 'editBook':
    $this->panelContent_1 = '<div style="overflow-x:auto;">'
        . HelperHTML::generateSelectTABLE($bookTable->getAllBooks(), 'book_id', 'editBook', 'Edit')
        . '</div>';
    break;
case 'deleteBook':
    $this->panelContent_1 = '<div style="overflow-x:auto; padding-bottom:5px;">'
        . HelperHTML::generateSelectTABLE($bookTable->getAllBooks(), 'book_id', 'deleteBook', 'Delete')
        . '</div>';
    break;
            case 'viewBorrowedBooks':
                $this->panelContent_1 = '<div style="overflow-x:auto; padding-bottom:5px;">'.HelperHTML::generateTABLE($bookTable->getAllBorrowedBooks()).'</div>';
                break;
            default:
                $this->panelContent_1 = '<div class="admin-book-menu">'
                        . '<a href="index.php?pageID=viewBooks">View All Books</a>'
                        . '<a href="index.php?pageID=addBook">Add New Book</a>'
                        . '<a href="index.php?pageID=editBook">Edit Book</a>'
                        . '<a href="index.php?pageID=deleteBook">Delete Book</a>'
                        . '<a href="index.php?pageID=viewBorrowedBooks">View Borrow Records</a>'
                        . '</div>';
                break;
        }
    }

    public function setPanelHead_2() {
        switch ($this->pageID) {
            case 'viewBooks':
                $this->panelHead_2 = '<h3>Books Overview</h3>';
                break;
            case 'addBook':
                $this->panelHead_2 = '<h3>Add Book Result</h3>';
                break;
            case 'editBook':
                $this->panelHead_2 = '<h3>Edit Book</h3>';
                break;
            case 'deleteBook':
                $this->panelHead_2 = '<h3>Delete Result</h3>';
                break;
            case 'viewBorrowedBooks':
                $this->panelHead_2 = '<h3>Borrow Records</h3>';
                break;
            default:
                $this->panelHead_2 = '<h3>Book Management</h3>';
                break;
        }
    }

    public function setPanelContent_2() {
        $bookTable = new BookTable($this->db);
        switch ($this->pageID) {
            case 'viewBooks':
                $this->panelContent_2 = 'Viewing all books currently stored in the library database.';
                break;
            case 'addBook':
                if (isset($this->postArray['btnAddBook'])) {
                    $this->panelContent_2 = $bookTable->addBook($this->postArray)
                        ? '<p class="text-success">New book added successfully.</p>'
                        : '<p class="text-danger">Unable to add book. Check the ISBN and category values.</p>';
                } else {
                    $this->panelContent_2 = 'Enter the new book details in the form on the left.';
                }
                break;
            case 'editBook':
                if (isset($this->postArray['btnRecordSelected'])) {
                    $bookID = (int)$this->postArray['recordSelected'];
                    $categoryTable = new CategoryTable($this->db);
                    $rs = $bookTable->getBookByID($bookID);
                    $this->panelContent_2 = $rs
                        ? Form::form_edit_book($categoryTable, $rs, $this->pageID)
                        : '<p class="text-danger">No book found with that ID.</p>';
                } elseif (isset($this->postArray['btnUpdateBook'])) {
                    $this->panelContent_2 = $bookTable->updateBook($this->postArray)
                        ? '<p class="text-success">Book record updated successfully.</p>'
                        : '<p class="text-danger">Unable to update book record.</p>';
                } else {
                    $this->panelContent_2 = 'Select a book from the list on the left to edit it.';
                }
                break;
            case 'deleteBook':
                if (isset($this->postArray['btnRecordSelected'])) {
                    $bookID = (int)$this->postArray['recordSelected'];
                    $this->panelContent_2 = $bookTable->deleteBook($bookID)
                        ? '<p class="text-success">Book deleted successfully.</p>'
                        : '<p class="text-danger">Unable to delete the selected book.</p>';
                } else {
                    $this->panelContent_2 = 'Select a book from the list on the left to delete it.';
                }
                break;
            case 'viewBorrowedBooks':
                $this->panelContent_2 = 'This page lists all borrow records captured in the library system.';
                break;
            default:
                $this->panelContent_2 = 'Use the links on the left to manage library books.';
                break;
        }
    }

    public function setPanelHead_3() {
        $this->panelHead_3 = '<h3>Admin Actions</h3>';
    }

    public function setPanelContent_3() {
        $this->panelContent_3 = " ";
    }
}
