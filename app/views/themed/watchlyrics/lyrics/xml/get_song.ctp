<?php 
echo "<LyricsResult>";
foreach($lyrics['Lyric'] as $lyric) {
    echo $xml->elem('artist', null, $lyrics['Artist']['name']);
    echo $xml->elem('song', null, $lyrics['Track']['name']);
    echo $xml->elem('lyrics', null, $lyric['text']);
    echo $xml->elem('url', null, $url);
    break;
}
echo "</LyricsResult>";
?>
