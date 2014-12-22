<?php
require( "classes/database.php");
$db = new database();
$db->initiate();

        $closed_days_query = "SELECT * FROM closed_days";
        $db->DoQuery($closed_days_query);
        $closed_days = $db->fetchAll(PDO::FETCH_NUM);

        echo "<pre>";
        print_r($closed_days);
        echo "</pre>";

                if (in_array("2014-12-25", $closed_days)) {
                    echo "closed";// It's a closed day.
                }
                if (in_array("2015-01-01", $closed_days)) {
                    echo "closed";// It's a closed day.
                }

// $url = "https://1994.game.co.uk/yoshimitsuratchet.php";

// $possible_answers = array(
// 	"kazuyatekken",
// 	"bruceleebrucelee",
// 	"yoshimitsuratchet"
// );

// 	$count = 0;
// foreach($possible_answers as $val) {
//     $url = "https://1994.game.co.uk/".$val.".php";
//     $CurlStart = curl_init();
// 	curl_setopt ($CurlStart, CURLOPT_URL, $url);
// 	curl_setopt ($CurlStart, CURLOPT_RETURNTRANSFER, 1);
// 	curl_setopt ($CurlStart, CURLOPT_REFERER, $url);
// 	curl_setopt ($CurlStart, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; nl; rv:1.9.1.11) Gecko/20100701 Firefox/3.5.11");
// 	curl_setopt ($CurlStart, CURLOPT_HEADER, 1);
// 	curl_setopt ($CurlStart, CURLOPT_FOLLOWLOCATION, true);
// 	$source = curl_exec ($CurlStart);
// 	curl_close ($CurlStart);

// 	$findme = '20th Anniversary Edition PlayStation 4 Console Product Details';
// 	$pos = strpos($source, $findme);

// 	echo $count++;

// 	if ($pos === false) {
// 	    echo " The string was not found in the string $val <br> <br>";
// 	} else {
// 		echo " we have a match <br>";
// 	    echo "The answer is $val <br>";
// 	    echo "<a href=''>$url</a> <br> <br>";
// 	}
// }


?>
