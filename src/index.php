<? require('./assets/php/partials/header.php'); ?>

<section class="content">
        <main>
                <? require('./assets/php/modules/landing.php'); ?>
        </main>

        <aside></aside>
        <aside></aside>
</section>

<? require('./assets/php/partials/footer.php'); ?>

<? /*
    if (isset($_GET['page'])) {
        $page = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['page']);
        switch ($page) {
            case 'user':
                pageUser();
                break;
            case 'index':
                pageIndex();
                break;
        }
    } */
?>
