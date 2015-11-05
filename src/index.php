<? 
    if (isset($_GET['page'])) {
        $page = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['page']);
        
        switch ($page) {
            case 'user':
                require_once('./assets/php/partials/user.php');
                require_once('./assets/php/partials/header.php');
                require_once('./assets/php/modules/user.php');
                require_once('./assets/php/partials/footer.php');
                break;
        }
    } else {
        require_once('./assets/php/partials/header.php');
        require_once('./assets/php/modules/index.php');
        require_once('./assets/php/partials/footer.php');
    }
?>
