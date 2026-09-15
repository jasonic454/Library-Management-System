<?php

class CustomerBooks extends PanelModel {

    protected $statusMessage = '';

    function __construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID){
        $this->modelType='CustomerBooks';
        if (isset($postArray['btnBorrowBook']) && isset($postArray['book_id'])) {
            $bookTable = new BookTable($db);
            if ($bookTable->borrowBook((int)$postArray['book_id'], $user->getUserID())) {
                $this->statusMessage = '<div class="alert alert-success">Book borrowed successfully.</div>';
            } else {
                $this->statusMessage = '<div class="alert alert-danger">Unable to borrow book. Please try again.</div>';
            }
        }
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    }

    protected function buildBookTable($rs) {
        if (!$rs) {
            return '<p>No books matched your search.</p>';
        }

        $html = "<table class='table table-striped table-bordered'>";
        $html .= "<tr><th>Title</th><th>Author</th><th>Category</th><th>ISBN</th><th>Available</th><th>Borrow</th></tr>";
        $foundRows = 0;
        while($row = $rs->fetch_assoc()){
            $foundRows++;
            $html .= "<tr>";
            $html .= "<td>".htmlspecialchars($row['title'])."</td>";
            $html .= "<td>".htmlspecialchars($row['author'])."</td>";
            $html .= "<td>".htmlspecialchars($row['category_name'])."</td>";
            $html .= "<td>".htmlspecialchars($row['isbn'])."</td>";
            $html .= "<td>".(int)$row['available_quantity']."</td>";
            $html .= "<td>";
            if ((int)$row['available_quantity'] > 0) {
                $html .= '<form method="post" action="index.php?pageID=viewBooks">';
                $html .= '<input type="hidden" name="book_id" value="'.(int)$row['book_id'].'">';
                $html .= '<button type="submit" class="btn btn-primary btn-xs" name="btnBorrowBook" value="borrow">Borrow</button>';
                $html .= '</form>';
            } else {
                $html .= '<span class="label label-default">Unavailable</span>';
            }
            $html .= "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";

        if ($foundRows === 0) {
            return '<p>No books matched your search.</p>';
        }
        return $html;
    }

    public function setPanelHead_1(){
        $this->panelHead_1 = '<h3>Search & Filter Books</h3>';
    }

    public function setPanelContent_1(){
        $categoryTable = new CategoryTable($this->db);
        $selectedCategory = isset($this->postArray['category_id']) ? (int)$this->postArray['category_id'] : 0;
        $search = isset($this->postArray['search']) ? htmlspecialchars($this->postArray['search']) : '';

        $html = '<form method="post" action="index.php?pageID=viewBooks">';
        $html .= '<div class="form-group">';
        $html .= '<label for="search">Search</label>';
        $html .= '<input type="text" class="form-control" id="search" name="search" value="'.$search.'" placeholder="Search by title, author, ISBN or category">';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label for="category_id">Category</label>';
        $html .= '<select class="form-control" id="category_id" name="category_id">';
        $html .= '<option value="0">All Categories</option>';
        if ($rsCat = $categoryTable->getAllRecords()) {
            while ($cat = $rsCat->fetch_assoc()) {
                $selected = ($selectedCategory === (int)$cat['category_id']) ? ' selected' : '';
                $html .= '<option value="'.(int)$cat['category_id'].'"'.$selected.'>'.htmlspecialchars($cat['category_name']).'</option>';
            }
        }
        $html .= '</select>';
        $html .= '</div>';
        $html .= '<button type="submit" class="btn btn-default" name="btnSearchBooks" value="search">Apply Filter</button>';
        $html .= '</form>';

        if ($this->statusMessage !== '') {
            $html .= $this->statusMessage;
        }

        $this->panelContent_1 = $html;
    }

    public function setPanelHead_2(){
        $this->panelHead_2 = '<h3>Available Books</h3>';
    }

    public function setPanelContent_2(){
        $bookTable = new BookTable($this->db);
        $search = isset($this->postArray['search']) ? $this->postArray['search'] : '';
        $categoryID = isset($this->postArray['category_id']) ? (int)$this->postArray['category_id'] : 0;
        $rs = $bookTable->getAllBooks($search, $categoryID, false);
        $this->panelContent_2 = $this->buildBookTable($rs);
    }

    public function setPanelHead_3(){
        $this->panelHead_3 = '<h3>Library Actions</h3>';
    }

    public function setPanelContent_3(){
        $this->panelContent_3 = '<ul>'
                . '<li>Browse all books currently stored in the library database.</li>'
                . '<li>Search by title, author, ISBN or category.</li>'
                . '<li>Filter books by category.</li>'
                . '<li>Borrow available books directly from the list.</li>'
                . '<li><a href="index.php?pageID=borrowHistory">View your borrowing history</a></li>'
                . '</ul>';
    }
}
