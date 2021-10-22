<?php
function copyright()
{
    /*
    Zerobyte.id
    Don't remove this copyright please !
    */
    system('clear');
    echo "
  _  __                               ___  _              _             
 | |/ / ___  _ _  __ _  _ _   __ _   / __|| |_   ___  __ | |__ ___  _ _ 
 | ' < / -_)| '_|/ _` || ' \ / _` | | (__ | ' \ / -_)/ _|| / // -_)| '_|
 |_|\_\\\___||_|  \__,_||_||_|\__, |  \___||_||_|\___|\__||_\_\\\___||_|  
                             |___/      Zerobyte Webshell Mass Checker";
}
copyright();
$green   = "\e[92m";
$red     = "\e[91m";
$keyword = array(
    "Webshell",
    "0Byte",
    "IndoXploit",
    "Shell",
    "shell",
    "wso"
); // Edit Here
echo "\nEnter Your List : ";
$url      = trim(fgets(STDIN));
$kontorus = file_get_contents($url);
$urls     = explode("\n", $kontorus);
$i        = 1;
foreach ($urls as $list) {
    echo "[" . $i . " / " . count($urls) . "]";
    $i++;
    $shell = explode(PHP_EOL, $list);
    foreach ($shell as $shellchk) {
        $url  = trim($shellchk);
        $keyx = '/' . implode('|', $keyword) . '/i';
        $ch   = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $shellcurl = curl_exec($ch);
        $httpcode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode == '200' OR preg_match("$keyx", $shellcurl)) {
            echo $green . "[LIVE!] $url\n\033[0m";
            $save = @fopen("live.txt", "a");
            fwrite($save, $url . "\n");
            fclose($save);
        }else{
            echo $red . "[DIE] $url\n\033[0m";
            $save = @fopen("die.txt", "a");
            fwrite($save, $url . "\n");
            fclose($save);
        }
    }
}
?>
