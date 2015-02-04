<?php
    header("Content-type: text/xml");
    echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">

    <url>
        <loc>https://hb.wopian.me</loc>
        <lastmod><?=date('Y-m-d');?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.00</priority>
    </url>

    <?php
        $db = new mysqli('localhost', 'bobstudi_humming', 'music195', 'bobstudi_hummingbird');

        if($db->connect_errno > 0){
            die('Unable to connect to database [' . $db->connect_error . ']');
        }

$sql = <<<SQL
    SELECT `id`, `name`
    FROM `users`
SQL;

        if(!$result = $db->query($sql)){
            die('There was an error running the query [' . $db->error . ']');
        }

        while($row = $result->fetch_assoc()){
            $name = $row['name'];
            echo "<url>
                    <loc>https://hb.wopian.me/".$name."</loc>
                    <lastmod>".date('Y-m-d')."</lastmod>
                    <changefreq>daily</changefreq>
                    <priority>0.9</priority>
                  </url>";
        }

        $result->free();
        $db->close();
    ?>

</urlset>
