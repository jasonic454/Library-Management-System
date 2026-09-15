<?php

class BookTable extends TableEntity {

    public function __construct($db) {
        parent::__construct($db, 'book');
    }

    public function getAllBooks($search = '', $categoryID = 0, $onlyAvailable = false) {
        $search = $this->db->real_escape_string(trim((string)$search));
        $categoryID = (int)$categoryID;
        $onlyAvailable = (bool)$onlyAvailable;

        $this->SQL = "SELECT b.book_id, b.title, b.author, b.isbn, c.category_name, b.quantity, b.available_quantity
                FROM book b
                INNER JOIN category c ON b.category_id = c.category_id";

        $conditions = array();
        if ($search !== '') {
            $conditions[] = "(b.title LIKE '%$search%' OR b.author LIKE '%$search%' OR b.isbn LIKE '%$search%' OR c.category_name LIKE '%$search%')";
        }
        if ($categoryID > 0) {
            $conditions[] = "b.category_id = $categoryID";
        }
        if ($onlyAvailable) {
            $conditions[] = "b.available_quantity > 0";
        }

        if (!empty($conditions)) {
            $this->SQL .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $this->SQL .= ' ORDER BY b.title';

        try {
            $rs = $this->db->query($this->SQL);
            if ($rs && $rs->num_rows >= 0) {
                return $rs;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false;
        }
    }

    public function getBookByID($bookID) {
        $bookID = (int)$bookID;
        $this->SQL = "SELECT b.book_id, b.title, b.author, b.isbn, b.category_id, c.category_name, b.quantity, b.available_quantity
                      FROM book b
                      INNER JOIN category c ON b.category_id = c.category_id
                      WHERE b.book_id = $bookID";
        try {
            $rs = $this->db->query($this->SQL);
            if ($rs && $rs->num_rows === 1) {
                return $rs;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false;
        }
    }

    public function addBook($postArray) {
        $title = $this->db->real_escape_string(trim($postArray['title'] ?? ''));
        $author = $this->db->real_escape_string(trim($postArray['author'] ?? ''));
        $isbn = $this->db->real_escape_string(trim($postArray['isbn'] ?? ''));
        $categoryID = (int)($postArray['category_id'] ?? 0);
        $quantity = (int)($postArray['quantity'] ?? 0);
        $available = (int)($postArray['available_quantity'] ?? $quantity);

        if ($title === '' || $author === '' || $isbn === '' || $categoryID <= 0 || $quantity < 0 || $available < 0 || $available > $quantity) {
            $this->MySQLiErrorMsg = 'Invalid book data provided.';
            return false;
        }

        $this->SQL = "INSERT INTO book (title, author, isbn, category_id, quantity, available_quantity)
                      VALUES ('$title', '$author', '$isbn', $categoryID, $quantity, $available)";
        try {
            $rs = $this->db->query($this->SQL);
            return ($rs && $this->db->affected_rows === 1);
        } catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false;
        }
    }

    public function updateBook($postArray) {
        $bookID = (int)($postArray['book_id'] ?? 0);
        $title = $this->db->real_escape_string(trim($postArray['title'] ?? ''));
        $author = $this->db->real_escape_string(trim($postArray['author'] ?? ''));
        $isbn = $this->db->real_escape_string(trim($postArray['isbn'] ?? ''));
        $categoryID = (int)($postArray['category_id'] ?? 0);
        $quantity = (int)($postArray['quantity'] ?? 0);
        $available = (int)($postArray['available_quantity'] ?? 0);

        if ($bookID <= 0 || $title === '' || $author === '' || $isbn === '' || $categoryID <= 0 || $quantity < 0 || $available < 0 || $available > $quantity) {
            $this->MySQLiErrorMsg = 'Invalid book data provided.';
            return false;
        }

        $this->SQL = "UPDATE book
                      SET title = '$title', author = '$author', isbn = '$isbn', category_id = $categoryID,
                          quantity = $quantity, available_quantity = $available
                      WHERE book_id = $bookID";
        try {
            $rs = $this->db->query($this->SQL);
            return (bool)$rs;
        } catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false;
        }
    }

    public function deleteBook($bookID) {
        $bookID = (int)$bookID;
        if ($bookID <= 0) {
            return false;
        }

        $this->SQL = "DELETE FROM book WHERE book_id = $bookID";
        try {
            $rs = $this->db->query($this->SQL);
            return ($rs && $this->db->affected_rows === 1);
        } catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false;
        }
    }

    public function borrowBook($bookID, $userID) {
        $bookID = (int)$bookID;
        $userID = $this->db->real_escape_string(trim((string)$userID));

        if ($bookID <= 0 || $userID === '') {
            return false;
        }

        mysqli_begin_transaction($this->db);
        try {
            $sqlUser = "SELECT UserNr FROM user WHERE userID = '$userID' LIMIT 1";
            $rsUser = $this->db->query($sqlUser);
            if (!$rsUser || $rsUser->num_rows !== 1) {
                throw new Exception('Unable to identify the current user.');
            }
            $userRow = $rsUser->fetch_assoc();
            $userNr = (int)$userRow['UserNr'];

            $sqlBook = "SELECT available_quantity FROM book WHERE book_id = $bookID FOR UPDATE";
            $rsBook = $this->db->query($sqlBook);
            if (!$rsBook || $rsBook->num_rows !== 1) {
                throw new Exception('Selected book was not found.');
            }
            $bookRow = $rsBook->fetch_assoc();
            if ((int)$bookRow['available_quantity'] <= 0) {
                throw new Exception('This book is currently unavailable.');
            }

            $sqlInsert = "INSERT INTO borrow_record (UserNr, book_id, borrow_date, status)
                          VALUES ($userNr, $bookID, CURDATE(), 'Borrowed')";
            $this->db->query($sqlInsert);

            $sqlUpdate = "UPDATE book SET available_quantity = available_quantity - 1 WHERE book_id = $bookID";
            $this->db->query($sqlUpdate);

            mysqli_commit($this->db);
            return true;
        } catch (mysqli_sql_exception $e) {
            mysqli_rollback($this->db);
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false;
        }
    }

    public function getBorrowHistoryByUser($userID) {
        $userID = $this->db->real_escape_string(trim((string)$userID));
        $this->SQL = "SELECT br.borrow_id, b.title, b.author, br.borrow_date, br.return_date, br.status
                      FROM borrow_record br
                      INNER JOIN user u ON br.UserNr = u.UserNr
                      INNER JOIN book b ON br.book_id = b.book_id
                      WHERE u.userID = '$userID'
                      ORDER BY br.borrow_date DESC, br.borrow_id DESC";
        try {
            $rs = $this->db->query($this->SQL);
            if ($rs) {
                return $rs;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false;
        }
    }

    public function getAllBorrowedBooks() {
        $this->SQL = "SELECT br.borrow_id, u.userID, CONCAT(u.FirstName, ' ', u.LastName) AS member_name,
                             b.title, br.borrow_date, br.return_date, br.status
                      FROM borrow_record br
                      INNER JOIN user u ON br.UserNr = u.UserNr
                      INNER JOIN book b ON br.book_id = b.book_id
                      ORDER BY br.borrow_date DESC, br.borrow_id DESC";
        try {
            $rs = $this->db->query($this->SQL);
            if ($rs) {
                return $rs;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false;
        }
    }

    /**
     * Records a book return - updates borrow_record status and increases available_quantity by 1.
     * Uses a transaction so both queries succeed or both are rolled back.
     *
     * @param int $borrowID The borrow_id of the record to return
     * @param string $userID The userID (email) of the returning user
     * @return boolean TRUE on success FALSE on failure
     */
    public function returnBook($borrowID, $userID){

        $borrowID = (integer)$borrowID;
        $userID   = $this->db->real_escape_string(trim((string)$userID));

        if($borrowID <= 0 || $userID === ''){
            return false;
        }

        mysqli_begin_transaction($this->db);
        try {
            //verify the borrow record belongs to this user and is still active
            $sqlCheck = "SELECT br.book_id FROM borrow_record br
                         INNER JOIN user u ON br.UserNr = u.UserNr
                         WHERE br.borrow_id = $borrowID
                         AND u.userID = '$userID'
                         AND br.status = 'Borrowed'
                         LIMIT 1";
            $rsCheck = $this->db->query($sqlCheck);
            if(!$rsCheck || $rsCheck->num_rows !== 1){
                throw new Exception('Borrow record not found or already returned.');
            }
            $row    = $rsCheck->fetch_assoc();
            $bookID = (integer)$row['book_id'];

            //update the borrow record
            $sqlUpdate = "UPDATE borrow_record
                          SET status = 'Returned', return_date = CURDATE()
                          WHERE borrow_id = $borrowID";
            $this->db->query($sqlUpdate);

            //increase available_quantity
            $sqlBook = "UPDATE book SET available_quantity = available_quantity + 1 WHERE book_id = $bookID";
            $this->db->query($sqlBook);

            mysqli_commit($this->db);
            return true;

        } catch (Exception $e) {
            mysqli_rollback($this->db);
            $this->MySQLiErrorNr = $e->getCode();
            $this->MySQLiErrorMsg = $e->getMessage();
            return false;
        }
    }
    //END METHOD: returnBook()

}
