<?php

$url=$argv[1];

if(!isset($argv[1]))
{
echo "\nUsage php grab.php <thread_url>\n";
exit;
}

$board=explode('/',$url);
$tag=$board[3];

$data=file_get_contents($url);
$base='https://media.8ch.net/'.$tag.'/src/';
$urls=getContents($data,'<a href="https://media.8ch.net/'.$tag.'/src/','"');
if(!count($urls))
{
	$urls=getContents($data,'<a href="https://media.8ch.net/file_store/','"');
	$base="https://media.8ch.net/file_store/";
}
$subject=getContents($data,'<span class="subject">','</span>');
$subject=$subject[0];
if($subject=='')
$subject=$board[5];
$subject=str_replace('/','_',$subject);
@mkdir($subject);

var_dump($urls);
foreach($urls as $a)
{
	echo "getting $a\n";
	$actual_file=file_get_contents($base.$a);
	file_put_contents($subject.'/'.$a,$actual_file);

}



function getContents($str, $startDelimiter, $endDelimiter) {
	$contents = array();
	$startDelimiterLength = strlen($startDelimiter);
	$endDelimiterLength = strlen($endDelimiter);
	$startFrom = $contentStart = $contentEnd = 0;
	while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
		$contentStart += $startDelimiterLength;
		$contentEnd = strpos($str, $endDelimiter, $contentStart);
		if (false === $contentEnd) {
			break;
		}
		$contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
		$startFrom = $contentEnd + $endDelimiterLength;
	}

	return $contents;
}
