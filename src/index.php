<? 
    function getHeader() {
        require('./assets/php/partials/header.php');
    }
    
    function getFooter() {
        require('./assets/php/partials/footer.php');
    }
    
    function getIndex() {
        getHeader()
        require('./assets/php/modules/index.php');
        getFooter()
    }
    
    function getUser() {
        getHeader()
        require('./assets/php/modules/user.php');
        getFooter()
    }
?>

<?
    if (isset($_GET['page'])) {
        $page = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['page']);
        switch ($page) {
            case 'user':
                getUser();
                break;
        }
    } else {
        getIndex();
    }
?>
