<?php
include_once('../simple_html_dom.php');

// $get_data_url = 'https://www.thansettakij.com/';
$get_data_url = 'https://www.thansettakij.com/thailand-elections/election-analysis/562937';

$id = 562937;

$item = array();

$now = date('c');
// $url = $_GET['url'];

if(isset($_GET['url'])){

    $url = $_GET['url'];
}else{

    $url = $get_data_url;
}

if(isset($_GET['folder'])){

    $folder = $_GET['folder'];
}else{

    $folder = $id;
}

$folder = 'thansettakij-'.$folder;

if(!is_dir('image')){
	mkdir('image');
}

$item['url'] = $url;

// get DOM from URL or file
$html = file_get_html($get_data_url);

// find title
echo "Title<br>";
foreach($html->find('title') as $e)
    echo $e->innertext . '<br>';
echo "<hr>";

// find description
echo "Description<br>";
foreach($html->find('meta[name=description]') as $e)
    echo $e->content . '<br>';
echo "<hr>";

// find keywords
echo "Keywords<br>";
foreach($html->find('meta[name=keywords]') as $e)
    echo $e->content . '<br>';
echo "<hr>";


// find viewport
echo "viewport<br>";
foreach($html->find('meta[name=viewport]') as $e)
    echo $e->content . '<br>';
echo "<hr>";



$texth1 = $texth2 = $texth3 = $texth4 = $texth5 = '';
// find h1
$num = 0;
foreach($html->find('h1') as $e){
    $texth1 .= '<li>' . $e->plaintext . '</li>';
    $num++;
}
echo "H1($num)<br>";
echo $texth1;

// find h2
$num = 0;
foreach($html->find('h2') as $e){
    $texth2 .= '<li>' . $e->plaintext . '</li>';
    $num++;
}
echo "H2($num)<br>";
echo $texth2;

// find h3
$num = 0;
foreach($html->find('h3') as $e){
    $texth3 .= '<li>' . $e->plaintext . '</li>';
    $num++;
}
echo "H3($num)<br>";
echo $texth3;


// find h4
$num = 0;
foreach($html->find('h4') as $e){
    $texth4 .= '<li>' . $e->plaintext . '</li>';
    $num++;
}
echo "H4($num)<br>";
echo $texth4;

// find h5
$num = 0;
foreach($html->find('h5') as $e){
    $texth5 .= '<li>' . $e->plaintext . '</li>';
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
foreach($html->find('meta[property=og:image]') as $e)
    echo $e->content . '<br>';
    
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
// find all image
echo "Image<br>";
foreach($html->find('div.contents img') as $e){
    if(trim($e->src) != ''){

        //************** save picture ****************
        $arr = explode("/", trim($e->src));

        if(!is_dir('image/'.$folder)){
            mkdir('image/'.$folder);
        }

        $filename = 'img-';

        //$location_img = 'image/'.$folder.'/'.md5(rand(100, 999)).'.jpg';
        $location_img = 'image/'.$folder.'/'.$filename.$i.'.jpg';
        
        if(!file_exists($location_img)){
            file_put_contents($location_img, file_get_contents($e->src));
            //Copy to destination
        }

        $item['img2'][] = $location_img;
		$i++;
        
        echo 'path = '. $e->src . '<br>';
        echo 'alt = '. $e->alt . '<br>';
        echo 'title = '. $e->title . '<br>';
        echo '<hr>';        
    }

}

echo "<hr>";
// find content
echo "Content<br>";
foreach($html->find('div.contents div.blurb-detail') as $e)
    // echo $e->plaintext . '<br>';
    echo $e->innertext . '<br>';

foreach($html->find('div.contents div.detail') as $e)
    // echo $e->plaintext . '<br>';
    echo $e->innertext . '<br>';



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
echo $bodyplaintext;
?>