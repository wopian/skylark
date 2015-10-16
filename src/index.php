<? 
    function getHeader() {
        require_once('./assets/php/partials/header.php');
    }
    
    function getFooter() {
        require_once('./assets/php/partials/footer.php');
    }
    
    function getIndex() {
        getHeader();
        require_once('./assets/php/modules/index.php');
        getFooter();
    }
    
    function getUser() {
        require_once('./assets/php/partials/user.php');
        getHeader();
        require_once('./assets/php/modules/user.php');
        getFooter();
    }

    if (isset($_GET['page'])) {
        $page = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['page']);
        global $page;
        switch ($page) {
            case 'user':
                getUser();
                break;
        }
    } else {
        getIndex();
    }
?>
