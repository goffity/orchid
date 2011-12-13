<?
require_once("magpierss/rss_fetch.inc");
	$url = $_GET['url'];
	if($url=="")$url="http://it.doa.go.th/refs/rss.php?where=serial%20RLIKE%20%22.%2B%22&showRows=100";
	$rss = fetch_rss( $url );
	
	echo "Channel Title: " . $rss->channel['title'] . "<p>";
	echo "<ul>";
	foreach ($rss->items as $item) {
		$href = $item['link'];
		$title = $item['title'];
		$desc = $item['description'];
		echo "<li><a href=$href>$title</a><br>$desc</li>";
	}
	echo "</ul>";
?>