<?php
header("Content-type: application/json; charset=utf-8");
ob_start();

$res = null;
include_once('../simple_html_dom.php');

// $get_data_url = 'https://www.bangkokbiznews.com/';
// $get_data_url = 'https://www.bangkokbiznews.com/business/economic/1065166';

$id = 562937;
$i = 0;
$item = array();

$now = date('c');
// $url = $_GET['url'];

if(isset($_POST['bangkokbiz_url'])){

    $url = $_POST['bangkokbiz_url'];
}else{

    $url = '';
}

if(isset($_POST['folder'])){

    $folder = $_POST['folder'];
}else{

    $folder = '';
}

$folder = 'bangkokbiz-'.$folder;

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
// find title
// echo "Title<br>";
foreach($html->find('title') as $e){
    // echo 'title:'. $e->innertext . '<br>';
    if(trim($e->innertext) != '')
        $item['title'] = $e->innertext;
}
// echo "<hr>";

// find description
// echo "Description<br>";
foreach($html->find('meta[name=description]') as $e){
    // echo $e->content . '<br>';
    $item['description'] = $e->content;
}
// echo "<hr>";

// find keywords
// echo "Keywords<br>";
foreach($html->find('meta[name=keywords]') as $e){
    // echo $e->content . '<br>';
    $item['keywords'] = $e->content;
}
// echo "<hr>";

// find viewport
// echo "viewport<br>";
foreach($html->find('meta[name=viewport]') as $e){
    // echo $e->content . '<br>';
    $item['viewport'] = $e->content;
}
// echo "<hr>";

// find canonical
// echo "Canonical<br>";
foreach($html->find('link[rel=canonical]') as $e){
    // echo $e->href . '<br>';
    $item['canonical'] = $e->href;
}
// echo "<hr>";

$texth1 = $texth2 = $texth3 = $texth4 = $texth5 = '';
// find h1
$num = 0;
foreach($html->find('h1') as $e){
    $texth1 .= '<li>' . $e->plaintext . '</li>';
    $item['h1'][] = $e->plaintext;
    $num++;
}
// echo "H1($num)<br>";
// echo $texth1;

// find h2
$num = 0;
foreach($html->find('h2') as $e){
    $texth2 .= '<li>' . $e->plaintext . '</li>';
    $item['h2'][] = $e->plaintext;
    $num++;
}
// echo "H2($num)<br>";
// echo $texth2;

// find h3
$num = 0;
foreach($html->find('h3') as $e){
    $texth3 .= '<li>' . $e->plaintext . '</li>';
    $item['h3'][] = $e->plaintext;
    $num++;
}
// echo "H3($num)<br>";
// echo $texth3;


// find h4
$num = 0;
foreach($html->find('h4') as $e){
    $texth4 .= '<li>' . $e->plaintext . '</li>';
    $item['h4'][] = $e->plaintext;
    $num++;
}
// echo "H4($num)<br>";
// echo $texth4;

// find h5
$num = 0;
foreach($html->find('h5') as $e){
    $texth5 .= '<li>' . $e->plaintext . '</li>';
    $item['h5'][] = $e->plaintext;
    $num++;
}
// echo "H5($num)<br>";
// echo $texth5;

// echo "<hr>";

// echo "<hr>";
// // find all image with full tag
// foreach($html->find('div.postarea div.inner img') as $e)
//     echo $e->outertext . '<br>';


// remove all image
// foreach($html->find('h1') as $e)
//     $e->outertext = '';

// echo $html;


// find facebook
/*
echo "facebook<br>title<br>";
foreach($html->find('meta[property=og:title]') as $e)
    echo $e->content . '<br>';

echo "description<br>";
foreach($html->find('meta[property=og:description]') as $e)
    echo $e->content . '<br>';

echo "image<br>";
foreach($html->find('meta[property=og:image]') as $e){

    echo $e->content . '<br>';
    
    $ext = pathinfo($e->content, PATHINFO_EXTENSION);
    $location_img = 'image/'.$folder.'/coverpage.'.$ext;
        
    if(!file_exists($location_img)){

        echo "<p>PUT $location_img, ".$e->content."</p>";
        file_put_contents($location_img, file_get_contents($e->content));
        //Copy to destination

        $item['img'][] = $e->content;
        $item['img2'][] = $location_img;
    }
}
*/

// echo "<hr>";

// find twitter
/*
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
*/
// echo "<hr>";


// find schema
// echo "schema<br>";
// foreach($html->find('script[type=application/ld+json]') as $e)
//     echo $e->innertext . '<hr>';
    // [@type=Organization]


// echo "favicon<br>";
foreach($html->find('link[rel=shortcut icon]') as $e){
    // echo $e->href . '<br>';
    $item['favicon'] = $e->href;
}
    
    
//<link rel="mask-icon" href="https://medias.thansettakij.com/images/logo.png" color="#000000" />
/*
foreach($html->find('link[rel=mask-icon]') as $e)
    echo $e->href . '<br>';
foreach($html->find('link[rel=apple-touch-icon]') as $e)
    echo $e->href . '<br>';
*/

// echo "Encoding<br>";
//     foreach($html->find('meta') as $e)
//         echo $e->innertext . '<br>';

// echo "<hr>";
// find content-feature-image
// echo "Image<br>";
foreach($html->find('div.content-feature-image img') as $e){
    if(trim($e->src) != ''){

        //************** save picture ****************
        $arr = explode("/", trim($e->src));

        if(!is_dir('image/'.$folder)){
            mkdir('image/'.$folder);
        }

        $i++;

        $filename = 'img-';

        $ext = pathinfo($e->src, PATHINFO_EXTENSION);
        //$location_img = 'image/'.$folder.'/'.md5(rand(100, 999)).'.jpg';
        $location_img = 'image/'.$folder.'/'.$filename.$i.'.'.$ext;
        // $location_img = 'image/'.$folder.'/'.$filename.$i.'.jpg';

        
        if(!file_exists($location_img)){

            // echo "<p>PUT $location_img, ".$e->src."</p>";
            // file_put_contents($location_img, file_get_contents($e->src));
            //Copy to destination
        }

        $item['img'][] = $e->src;
        $item['img2'][] = $location_img;
		// $i++;
        
        // echo 'path = '. $e->src . '<br>';
        // echo 'alt = '. $e->alt . '<br>';
        // echo 'title = '. $e->title . '<br>';
        // echo '<hr>';        
    }

}


// echo "<hr>";
// find all image
// echo "Image<br>";
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
        //$location_img = 'image/'.$folder.'/'.md5(rand(100, 999)).'.jpg';
        // $location_img = 'image/'.$folder.'/'.$filename.$i.'.'.$ext;
        $location_img = 'image/'.$folder.'/'.$filename.$i.'.jpg';

        
        if(!file_exists($location_img)){

            // echo "<p>PUT $location_img, ".$e->src."</p>";
            // file_put_contents($location_img, file_get_contents($e->src));
            //Copy to destination
        }

        $item['img'][] = $e->src;
        $item['img2'][] = $location_img;
		// $i++;
        
        // echo 'path = '. $e->src . '<br>';
        // echo 'alt = '. $e->alt . '<br>';
        // echo 'title = '. $e->title . '<br>';
        // echo '<hr>';
    }

}

// echo "<hr>";
// find content
// echo "Content<br>";
foreach($html->find('div#contents h2.content-blurb') as $e){
    // echo $e->plaintext . '<br>';
    // echo $e->innertext . '<br>';
    $item['content'] = $e->plaintext;
}

foreach($html->find('div#contents div#paragraph-1') as $e){
    // echo $e->plaintext . '<br>';
    // echo $e->innertext . '<br>';
    $item['content'] .= $e->plaintext;
}

foreach($html->find('div#contents div#paragraph-2') as $e){
    // echo $e->plaintext . '<br>';
    // echo $e->innertext . '<br>';
    $item['content'] .= $e->plaintext;
}

foreach($html->find('div#contents div#paragraph-3') as $e){
    // echo $e->plaintext . '<br>';
    // echo $e->innertext . '<br>';
    $item['content'] .= $e->plaintext;
}

// echo "<hr>";
foreach($html->find('body') as $e){
    $bodytext = $e->innertext;
    $bodyplaintext = $e->plaintext;
}

$data_text = '';

ob_clean();
$res = $item;
echo json_encode($res);
ob_end_flush();

// echo "<pre>";
// print_r($item);
// echo "</pre>";
?>