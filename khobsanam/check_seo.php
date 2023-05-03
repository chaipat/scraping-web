<!-- <!DOCTYPE html> -->
<html lang="th">
    <head>
	<meta charset="utf-8"/>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport"/>
	<title>Scraping khobsanam</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;300&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<style>
	body{
		font-family: 'Kanit', sans-serif;
	}
	</style>
</head>
<body>
    <div class="container">
    <h1>Scraping khobsanam</h1>
<?php
include_once('../simple_html_dom.php');

// $get_data_url = 'https://www.khobsanam.com/';
// $get_data_url = 'https://www.khobsanam.com/';

$id = 547481;
$i = 0;
$item = array();

$now = date('c');
// $url = $_GET['url'];

if(isset($_POST['khobsanam_url'])){

    $url = $_POST['khobsanam_url'];
}else{

    $url = '';
}

if(isset($_POST['folder'])){

    $folder = $_POST['folder'];
}else{

    $folder = '';
}

echo '<form class="row g-3" method="POST">
<div class="mb-3">
    <label for="URL" class="form-label">URL</label>
    <input type="text" class="form-control" name="khobsanam_url" value="'.$url.'" placeholder="ex. https://www.khobsanam.com">
</div>
<div class="mb-3">
    <label for="folder" class="form-label">folder</label>
    <input type="text" class="form-control" name="folder" value="'.$folder.'" placeholder="ex. 547481">
</div>
<button type="submit" class="btn btn-primary mb-3">Submit</button>
<hr>
</form>';

$folder = 'khobsanam-'.$folder;

// echo $url."<br>";
// echo $folder."<hr>";
// die();

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// echo "<hr>";

if(!is_dir('image')){
	mkdir('image');
}

$item['url'] = $url;

// get DOM from URL or file
$html = file_get_html($url);

// echo "<pre>";
// print_r($html);
// echo "</pre>";

// die();

// find title
echo "Title<br>";
foreach($html->find('title') as $e){
    echo $e->innertext . '<br>';
    $item['title'] = $e->innertext;
}
echo "<hr>";

// find description
echo "Description<br>";
foreach($html->find('meta[name=description]') as $e){
    echo $e->content . '<br>';
    $item['description'] = $e->content;
}
echo "<hr>";

// find keywords
echo "Keywords<br>";
foreach($html->find('meta[name=keywords]') as $e){
    echo $e->content . '<br>';
    $item['keywords'] = $e->content;
}
echo "<hr>";

// find viewport
echo "viewport<br>";
foreach($html->find('meta[name=viewport]') as $e){
    echo $e->content . '<br>';
    $item['viewport'] = $e->content;
}
echo "<hr>";

// find canonical
echo "Canonical<br>";
foreach($html->find('link[rel=canonical]') as $e){
    echo $e->href . '<br>';
    $item['canonical'] = $e->href;
}
echo "<hr>";

$texth1 = $texth2 = $texth3 = $texth4 = $texth5 = '';
// find h1
$num = 0;
foreach($html->find('h1') as $e){
    $texth1 .= '<li>' . $e->plaintext . '</li>';
    $item['h1'][] = $e->plaintext;
    $num++;
}
echo "H1($num)<br>";
echo $texth1;

// find h2
$num = 0;
foreach($html->find('h2') as $e){
    $texth2 .= '<li>' . $e->plaintext . '</li>';
    $item['h2'][] = $e->plaintext;
    $num++;
}
echo "H2($num)<br>";
echo $texth2;

// find h3
$num = 0;
foreach($html->find('h3') as $e){
    $texth3 .= '<li>' . $e->plaintext . '</li>';
    $item['h3'][] = $e->plaintext;
    $num++;
}
echo "H3($num)<br>";
echo $texth3;


// find h4
$num = 0;
foreach($html->find('h4') as $e){
    $texth4 .= '<li>' . $e->plaintext . '</li>';
    $item['h4'][] = $e->plaintext;
    $num++;
}
echo "H4($num)<br>";
echo $texth4;

// find h5
$num = 0;
foreach($html->find('h5') as $e){
    $texth5 .= '<li>' . $e->plaintext . '</li>';
    $item['h5'][] = $e->plaintext;
    $num++;
}
echo "H5($num)<br>";
echo $texth5;

echo "<hr>";

// echo "<hr>";
// // find all image with full tag
// foreach($html->find('div.postarea div.inner img') as $e)
//     echo $e->outertext . '<br>';


// remove all image
// foreach($html->find('h1') as $e)
//     $e->outertext = '';

// echo $html;



// find facebook
echo "facebook<br>title<br>";
foreach($html->find('meta[property=og:title]') as $e)
    echo $e->content . '<br>';

echo "description<br>";
foreach($html->find('meta[property=og:description]') as $e)
    echo $e->content . '<br>';

echo "image<br>";
foreach($html->find('meta[property=og:image]') as $e){

    echo $e->content . '<br>';
    
    // $location_img = 'image/'.$folder.'/coverpage.jpg';
        
    // if(!file_exists($location_img)){

    //     echo "<p>PUT $location_img, ".$e->content."</p>";
    //     file_put_contents($location_img, file_get_contents($e->content));
    //     //Copy to destination

    //     $item['img'][] = $e->content;
    //     $item['img2'][] = $location_img;
    // }
}

echo "<hr>";

// find twitter
echo "twitter<br>title<br>";
foreach($html->find('meta[property=twitter:title]') as $e)
    echo $e->content . '<br>';

echo "description<br>";
foreach($html->find('meta[property=twitter:description]') as $e)
    echo $e->content . '<br>';

echo "image<br>";
foreach($html->find('meta[property=twitter:image]') as $e)
    echo $e->content . '<br>';
 
echo "card<br>";
foreach($html->find('meta[name=twitter:card]') as $e)
    echo $e->content . '<br>';

echo "site<br>";
foreach($html->find('meta[name=twitter:site]') as $e)
    echo $e->content . '<br>';

echo "<hr>";


// find schema
// echo "schema<br>";
// foreach($html->find('script[type=application/ld+json]') as $e)
//     echo $e->innertext . '<hr>';
    // [@type=Organization]


echo "favicon<br>";
foreach($html->find('link[rel=shortcut icon]') as $e)
    echo $e->href . '<br>';
    
//<link rel="mask-icon" href="https://medias.thansettakij.com/images/logo.png" color="#000000" />
foreach($html->find('link[rel=mask-icon]') as $e)
    echo $e->href . '<br>';
foreach($html->find('link[rel=apple-touch-icon]') as $e)
    echo $e->href . '<br>';
    
// echo "Encoding<br>";
//     foreach($html->find('meta') as $e)
//         echo $e->innertext . '<br>';

echo "<hr>";
echo "Image<br>";
foreach($html->find('div.content-feature-image img') as $e){
    if(trim($e->src) != ''){

        //************** save picture ****************
        $arr = explode("/", trim($e->src));

        if(!is_dir('image/'.$folder)){
            mkdir('image/'.$folder);
        }

        $filename = 'img-';

        $ext = pathinfo($e->src, PATHINFO_EXTENSION);
        if($ext == '') $ext = 'jpg';
        //$location_img = 'image/'.$folder.'/'.md5(rand(100, 999)).'.jpg';
        // $location_img = 'image/'.$folder.'/'.$filename.$i.'.jpg';
        $location_img = 'image/'.$folder.'/cover-page.'.$ext;

        if(!file_exists($location_img)){

            echo "<p>PUT $location_img, ".$e->src."</p>";
            file_put_contents($location_img, file_get_contents($e->src));
            //Copy to destination
        }

        $item['img'][] = $e->src;
        $item['img2'][] = $location_img;
		// $i++;
        
        echo 'path = '. $e->src . '<br>';
        echo 'alt = '. $e->alt . '<br>';
        echo 'title = '. $e->title . '<br>';
        echo '<hr>';        
    }

}


echo "<hr>";
// find all image
echo "Image<br>";
foreach($html->find('div.content-detail img') as $e){
    if(trim($e->src) != ''){

        //************** save picture ****************
        $arr = explode("/", trim($e->src));

        if(!is_dir('image/'.$folder)){
            mkdir('image/'.$folder);
        }

        $i++;

        $filename = 'img-';

        $ext = pathinfo($e->src, PATHINFO_EXTENSION);
        if($ext == '') $ext = 'webp';
        //$location_img = 'image/'.$folder.'/'.md5(rand(100, 999)).'.jpg';
        $location_img = 'image/'.$folder.'/'.$filename.$i.'.'.$ext;
        
        if(!file_exists($location_img)){

            echo "<p>PUT $location_img, ".$e->src."</p>";
            file_put_contents($location_img, file_get_contents($e->src));
            //Copy to destination
        }

        $item['img'][] = $e->src;
        $item['img2'][] = $location_img;
		// $i++;
        
        echo 'path = '. $e->src . '<br>';
        echo 'alt = '. $e->alt . '<br>';
        echo 'title = '. $e->title . '<br>';
        echo '<hr>';        
    }

}

echo "<hr>";
// find content
echo "Content<br>";
foreach($html->find('div.article-content div#section-1') as $e){
    // echo $e->plaintext . '<br>';
    echo $e->innertext . '<br>';
    $item['content'] = $e->plaintext;
}

foreach($html->find('div.article-content div#section-2') as $e){
    // echo $e->plaintext . '<br>';
    echo $e->innertext . '<br>';
    $item['content'] .= $e->plaintext;
}

foreach($html->find('div.article-content div#section-3') as $e){
    // echo $e->plaintext . '<br>';
    echo $e->innertext . '<br>';
    $item['content'] .= $e->plaintext;
}

echo "<hr>";
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

    $location_txt = 'image/'.$folder.'/news-detail.txt';

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
    </div>
<script defer src="https://kit.fontawesome.com/425fce21f6.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>