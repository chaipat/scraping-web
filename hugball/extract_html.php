<?php
include_once('../simple_html_dom.php');

ini_set('user_agent', 'My-Application/2.5');


// $get_data_url = 'https://board.hugball.net/sexy-room/(-18)-9368';
// $get_data_url = 'https://board.hugball.net/sexy-room/(-18)-aumamii';
// $get_data_url = 'https://board.hugball.net/sexy-room/(-18)-eye-9306';
$get_data_url = 'https://board.hugball.net/sexy-room/(-18)-maeylin-9311';


$item = array();
$i = 0;
$item['h1'] = null;

$now = date('c');
if(isset($_GET['url'])){

    $url = $_GET['url'];
}else{

    $url = $get_data_url;
}

// echo $_GET['url'];
// die();

if(isset($_GET['folder'])){

    $folder = $_GET['folder'];
}else{

    $folder = 'maeylin-9311';
}
$folder = 'hugball-'.$folder;

if(!is_dir('image')){
	mkdir('image');
}

$item['url'] = $url;

// get DOM from URL or file
$html = file_get_html($url);



// find title
// echo "Title<br>";
foreach($html->find('title') as $e){
    // echo $e->innertext . '<br>';
    $item['title'] = $e->innertext;
}

// find description
// echo "Description<br>";
foreach($html->find('meta[name=description]') as $e){
    // echo $e->content . '<br>';
    $item['description'] = $e->content;
}

// find h1
// echo "H1<br>";
foreach($html->find('h1') as $e){
    // echo $e->plaintext . '<br>';
    $item['h1'][] = $e->plaintext;
}

// find h2
// echo "H2<br>";
foreach($html->find('h2') as $e){
    // echo $e->plaintext . '<br>';
    $item['h2'][] = $e->plaintext;
}

// find h3
// echo "H3<br>";
foreach($html->find('h3') as $e){
    // echo $e->plaintext . '<br>';
    $item['h3'][] = $e->plaintext;
}

// find h4
// echo "H4<br>";
foreach($html->find('h4') as $e){
    // echo $e->plaintext . '<br>';
    $item['h4'][] = $e->plaintext;
}

// find h5
// echo "H5<br>";
foreach($html->find('h5') as $e){
    // echo $e->plaintext . '<br>';
    $item['h5'][] = $e->plaintext;
}

// echo "<hr>";
// find all image
// echo "Image<br>";
foreach($html->find('div.postarea div.inner img') as $e){
    if(trim($e->src) != ''){

        //************** save picture ****************
        $arr = explode("/", trim($e->src));

        if(!is_dir('image/'.$folder)){
            mkdir('image/'.$folder);
        }

        $filename = 'img-';

        //$location_img = 'image/'.$folder.'/'.md5(rand(100, 999)).'.jpg';
        $location_img = 'image/'.$folder.'/'.$filename.$i.'.jpg';
        
        // echo "<p>$location_img</p>";

        if(!file_exists($location_img)){

            echo "<p>PUT $location_img, ".$e->src."</p>";
            file_put_contents($location_img, file_get_contents($e->src));
            //Copy to destination
        }

        $item['img'][] = $e->src;
        $item['img2'][] = $location_img;
		$i++;
        
        // echo 'path = '. $e->src . '<br>';
        // echo 'alt = '. $e->alt . '<br>';
        // echo 'title = '. $e->title . '<br>';
        // echo '<hr>';        
    }

}

// echo "<hr>";
// // find all image with full tag
// foreach($html->find('div.postarea div.inner img') as $e)
//     echo $e->outertext . '<br>';

// remove all image
// foreach($html->find('h1') as $e)
//     $e->outertext = '';

// echo $html;

// echo "<hr>";
// find content
// echo "Content<br>";
foreach($html->find('div.postarea div.inner') as $e){
    // echo $e->plaintext . '<br>';
    // echo $e->innertext . '<br>';
    $item['content'] = $e->plaintext;
}

// echo "<hr>";
foreach($html->find('body') as $e){
    $bodytext = $e->innertext;
    $bodyplaintext = $e->plaintext;
}
// echo $bodytext.'<br>';

$fulllen = strlen($bodytext);

// $plaintext = file_get_html($get_data_url)->plaintext;
$textlen = strlen($bodyplaintext);

$fulllen = $fulllen - $textlen;
$perc = ($textlen/$fulllen)*100;

echo "($textlen)/($fulllen) = $perc";
echo "<hr>";
// echo $bodyplaintext;

echo "<pre>";
print_r($item);
echo "</pre>";



$data_text = '';

if($item){

	/*if($item['text']){
		$alltext =count($item['text']);
		for($i = 0; $i < $alltext; $i++) {
			echo '<p>'.$item['text'][$i].'</p>';

			if(trim($item['text'][$i]) <> ""){
				if($i == 0)
					$data_text .= $item['text'][$i];
				else
					$data_text .= "<p>".$item['text'][$i]."</p>\n";
			}
		}

		if($data_text != '')
			SaveFiles($data_text."\n\n".$item['url'], $item['filesname']);
	}*/

    if($item['title']){
        $data_text .= 'Title:'.$item['title'];
        $data_text .= "\n";
    }
    if($item['description']){
        $data_text .= 'Description:'.$item['description'];
        $data_text .= "\n";
    }
    if($item['content']){
        $data_text .= 'Content:'.$item['content'];
    }
    $data_text .= "\n";

    $all =count($item['img2']);
	for($i = 0; $i < $all; $i++) {

        if($i == 0)
            $data_text .= '
            <img data-src="'.$item['img2'][$i].'" src="'.$item['img2'][$i].'" ><br>';
        else
            $data_text .= '
            <img data-src="'.$item['img2'][$i].'" src="'.$item['img2'][$i].'" width="400"><br>';
	}

    $data_text .= "\n\n";
    $all =count($item['img']);
	for($i = 0; $i < $all; $i++) {

        if($i == 0)
            $data_text .= '
            <img data-src="'.$item['img'][$i].'" src="'.$item['img'][$i].'" ><br>';
        else
            $data_text .= '
            <img data-src="'.$item['img'][$i].'" src="'.$item['img'][$i].'" width="400"><br>';
	}

    $location_txt = 'image/'.$folder.'/'.$folder.'.txt';

    if($data_text != '')
		SaveFiles($data_text."\n\n".$item['url'], $location_txt);

}else{

	echo "Can not read.";
}

function SaveFiles($data, $filename){
	$objFopen=fopen($filename,'w');
	fwrite($objFopen, $data);
	fclose($objFopen);
}
?>