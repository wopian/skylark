<!DOCTYPE html>
<html>

<head>
    <title>TOP SECRET</title>
    <style>
        pre {
            font-size: 10pt;
            font-family: "Fira Code";
            font-weight: bold;
        }
    </style>
</head>

<body>

<?php
    if ($_GET['wopian'] === "1") {

        $counter = 0;

        # https://gist.github.com/NuckChorris/fd73d6744e56545c8def
        # $url = "https://gist.github.com/NuckChorris/fd73d6744e56545c8def/raw/674266cc5edf294e70b39e75298dbb52911b7332/2014_season_stats.json";

        $url = "https://gist.github.com/NuckChorris/fd73d6744e56545c8def/raw/7bad79aead47eddeba5667a422c7f5c00f31fc3a/2014_type_stats.json";

        # Turns URL into JSON
        $json = file_get_contents($url);

        # Turns JSON into PHP array()
        $data = json_decode($json, true);

        # Target data needed
        $data = $data['TV'];

        # Create an empty array() for the foreach loop
        $sort = array();

        # Loop through the array
        foreach ($data as $key => $row) {

            # Use for Most Popular
            $sort[$key] = $row['count'];

            # Use for Highest Rated
            #if($row['count'] > 0){
            #    $sort[$key] = $row['rating'];
            #} else {
            #    $sort[$key] = 0;
            #}
        }

        # Sort the array by 'count' or 'rating' as defined above
        array_multisort($sort, SORT_DESC , $data);

        # Print array into webpage from highest to lowest count
        foreach ($data as $key => $row) {
            $counter++;
            print "<pre>" .
                $counter .
                ")<br>" .

                # Use $key for Genres and Seasons,
                # Use $row['slug'] for Type.
                #$key .
                $row['slug'] .

                "<br>View: " . $row['count'] .
                "<br>Rati: " . round($row['rating'], 2) .
                "<br>" .
                "<br>Comp: " . $row['distribution']['Completed'] .
                "<br>Curr: " . $row['distribution']['Currently Watching'] .
                "<br>Drop: " . $row['distribution']['Dropped'] .
                "<br>On H: " . $row['distribution']['On Hold'] .
                "<br>Plan: " . $row['distribution']['Plan to Watch'] .
                "<br><br></pre>";
        }

    } else {
        print "Don't be a sneaky jerk ;)";
    }
?>

</body>

</html>
