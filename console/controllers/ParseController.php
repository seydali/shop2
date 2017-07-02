<?php

namespace console\controllers;
use yii\helpers\Console;
use common\models\Products;

use Yii;

class ParseController extends \yii\Console\Controller
{

    public function actionParser()
    {

                $text = self::content( 'http://www.softkey.ru/index.php?ndcn=P3Nob3dNb3JlSWRzPTEwMDAwMDAw' );
        preg_match('/<div class=\"attribute_title\">Категория<\\/div>(.*)<span class=\"menu_action\">Свернуть<\/span>/isu', $text, $cats);

        //preg_match_all("/<a class=\"\"(.*)<\\/a>/", $cats, $links);
        $links=array();

        foreach($cats as $cat)
        {
            preg_match_all("/<a class=\"\" href=\"(.*)\" >(.*)<\\/a>/", $cat, $links);
        }


            for($ii=0; $ii<=sizeof($links[1]); $ii++)
        {

            $href=$links[1][$ii];

            if(!$href) continue;

            $product = new Products();
            if($product->addUrl('http://www.softkey.ru'.$href)==1) continue;
            echo 'CategLink - '.'http://www.softkey.ru'.$href."\n";
            $text = self::content( 'http://www.softkey.ru'.$href);
            //echo 'http://www.softkey.ru'.$href."\n";
            preg_match('~<span id="page-counter-bottom" class="c_center">1 из (.*)</span>~', $text, $x);
            $maxpage=(int)$x[1];

            $product = new Products();
            if($product->addUrl('http://www.softkey.ru'.$href."#page1")==1) continue;
            echo 'FirstPageCat - '.'http://www.softkey.ru'.$href."#page1"."\n";
            $text = self::content( 'http://www.softkey.ru'.$href."#page1");

            preg_match('/<script type="text\/html" id="pagingActionTemplate-tpl">(.*)<\/script>/',$text,$tplLink);
            //           var_dump($tplLink);


            for($i=0; $i<$maxpage; $i++)
            {


                ///_/N-10009687?No={offset}&Nrpp=&showMoreIds=10000000
                $parsedLink=str_replace('{offset}', $i*5, $tplLink[1]);

                $parsedLink= 'http://www.softkey.ru/softkey/ajax/ResultList'.str_replace('{recordsPerPage}', '5', $parsedLink);

                $product = new Products();
                if($product->addUrl($parsedLink)==1) continue;
                echo 'PageLink - '.$parsedLink."\n";
                $text = self::content($parsedLink);

                //var_dump($parsedLink);

                $prod_link=null;
                preg_match_all('/<a class="r30 url" href="(.*)"/sU', $text, $prod_link);
                //var_dump($prod_link);
                //die;
                 foreach($prod_link[1] as $prodLink) {
                     $product = new Products();
                     if($product->addUrl($prodLink)==1) {
                         echo 'ProductLink [continue] - '.$parsedLink."\n";
                         continue;
                     }
                     echo 'ProductLink - '.$parsedLink."\n";
                         $prod_page = self::content('http://www.softkey.ru' . $prodLink);
                         preg_match('/<div id="short_desc_c" style="">(.*)<\/div>/sU', $prod_page, $description);
                         preg_match('/<div id="sys_req_c" style="display:none;">(.*)<\/div>/sU', $prod_page, $sys_req);
                         preg_match('/((<span class="price"><b>от )|(<span class="price"><b>))(.*) руб./Us', $prod_page, $price);
                         preg_match('/<span class="gray1">Платформы:<\/span>(.*)<\/p>/sU', $prod_page, $platform);
                         preg_match('/<a title="Поставщик"(.*)<strong>(.*)<\/strong>/sU', $prod_page, $manufacturer);
                         preg_match('/<span class="m8">(.*)<\/span>/', $platform[1], $platform);
                         preg_match('/<h1 class="grade">(.*)<\/h1>/U', $prod_page, $prodName);
                         preg_match_all($re = '/"LINK":"(.*)",/U', $prod_page, $images);
                         $images = $images[1];


                         if (sizeof($images) < 1) {
                             //                         preg_match_all('/<p class="single-main-screenshot pic pic_main_pr20">\n *<img src="(.*)"/Us', $prod_page, $images);
                             preg_match_all('/<p class="single-main-screenshot pic pic_main_pr20">(.*)<img src="(.*)"/Us', $prod_page, $images);
                             $images = $images[2];
                             echo "\nStart IMAGES:\n";
                             var_dump($images);
                             echo "\nEnd IMAGES:\n";
                             //o $prod_page;
                             // die;
                         }
                         //


                         $platform = explode("&nbsp;|&nbsp;", $platform[1] . "&nbsp;|&nbsp;");
                         //var_dump($platform);
                         $platform = array_filter($platform);
                         // var_dump($platform);
                         $price = (double)str_replace(' ', '', $price[4]);
                         if (empty($prodName[1])) {
                             echo 'if(!empty($prodName[1]))' . "\n";
                             continue;
                         }
                         echo $prodName[1] . "\n";
                         if (Products::findByName($prodName[1])) {
                             echo 'Products::findByName($prodName[1]' . "\n";
                             continue;
                         }
                         echo 'new Products();' . "\n";
                         $product = new Products();
                         //print_r($sys_req[1]);
                         //print_r($price[1]);
                         //print_r($description[1]);
                         $product->name = $prodName[1];
                         $product->system_requirements = $sys_req[1];
                         $product->price = $price;
                         $product->description = $description[1];
                         if (!$product->validate()) {
                             var_dump($product->errors);
                             continue;
                         }
                         $product->save();
                         for ($i = 0; $i < sizeof($images); $i++) {
                             $name = $product->id . "_" . $i;
                             $path = $this->ImageDownload('http:' . $images[$i], 'frontend/web/uploads/' . $name . '.png');
                             //print_r($images[$i]);
                             //die;
                             $this->imgResize($path, 100);
                             $this->imgResize($path, 150);
                             $path=str_replace('frontend/web/','', $path);
                             $product->AddImagesLinks($path);
                         }

                         echo '$product->id()' . $product->id . "\n";

                         //$path=$this->ImageDownload($url, $product->id);
                         //$product->AddImagesLinks($path);
                         $product->AddOsLinks($platform);
                         //var_dump($manufacturer[2]);
                         if (!empty($manufacturer)) {
                             $product->AddManufacturersLinks($manufacturer[2]);
                         }
                         $category = $links[2][$ii];
                         if ($category)
                             $product->AddProductLinks($category);

                         //$manufacturers->name=$manufacturer[2];


                 }
            }
            //;*/
        }
echo 'END';
    }
    public function ImageDownload($url, $path) {
        echo $url;
       // die;
        if(substr_count($url, '//www.softkey.ru')>1)
        {
            echo $url;
            $url=str_replace("//www.softkey.ru//www.softkey.ru", '//www.softkey.ru', $url);
            echo $url;
            //die;
        }

        $ch = curl_init($url);
        $fp = fopen($path, 'a');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return($path);
    }
    private static function content($url)
    {
        $curl_errno =0;
        $retcount=10;
        $reqtimeout=3;
        $data='';
        do {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
            $data = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);
            if($curl_errno>0)
            {
                $retcount--;
                echo ">rettrive data $retcount\n";
                echo "curl_error: $curl_error\n";
            }else
                sleep($reqtimeout);
            curl_close($ch);
        }while(($curl_errno>0)&&($retcount>0));
        return $data;
    }
    public function imgResize($path,$size)
    {
        $type=exif_imagetype($path);
        echo "ТИП=".$type."\n";
        // исходное изображение
        $source = $path;
        $new_file =str_replace("uploads/", "uploads/min/".$size."/", $path);
// путь для сохранения новой картинки

        $width = $size; // новая ширина
        $height = $size; // новая высота
//узнаем размеры исходной картинки
        $size = getimagesize($source);
//пропорция ширины
        $x_ratio = $width / $size[0];
//пропорция высоты
        $y_ratio = $height / $size[1];
// определяем соотношения ширины к высоте
        $ratio = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);
// высчитываем новую ширину картинки
        $new_width = $use_x_ratio ? $width :
            floor($size[0] * $ratio);
// высчитываем новую высоту картинки
        $new_height = ! $use_x_ratio ? $height :
            floor($size[1] * $ratio) ;
// расхождение с заданными параметрами по ширине
        $new_left = $use_x_ratio ? 0 :
            floor(($width - $new_width) / 2);
// расхождение с заданными параметрами по высоте
        $new_top = ! $use_x_ratio ? 0 :
            floor(($height - $new_height) / 2);
// создаем холст пропорциональное сжатой картинке
        $img = imagecreatetruecolor($width, $height);
// делаем его прозрачным
        imagesavealpha($img, true);
        imagealphablending($img, false);
        $trans_colour = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $trans_colour);
// загружаем исходную картинку
         if($type==3) {
             $photo = imagecreatefrompng($source);
         }
         elseif($type==2)
         {
             $photo = imagecreatefromjpeg($source);
         }
         elseif($type==1)
         {
             $photo = imagecreatefromgif($source);
         }
         elseif($type==6)
         {
             $photo = $this->imagecreatefrombmp($source);
         }
        if($type!=3&&$type!=2&&$type!=1)
        {
            return 0;
        }







// копируем на холст сжатую картинку
// с учетом расхождений
        imagecopyresampled($img, $photo, $new_left, $new_top,
            0, 0, $new_width, $new_height, $size[ 0], $size[1]);
// сохраняем результат
        imagepng($img, $new_file);
// очищаем память после выполнения скрипта
        imagedestroy($img);
        imagedestroy($photo);
    }
    public function imagecreatefrombmp($p_sFile)
    {
        $file    =    fopen($p_sFile,"rb");
        $read    =    fread($file,10);
        while(!feof($file)&&($read<>""))
            $read    .=    fread($file,1024);
        $temp    =    unpack("H*",$read);
        $hex    =    $temp[1];
        $header    =    substr($hex,0,108);
        if (substr($header,0,4)=="424d")
        {
            $header_parts    =    str_split($header,2);
            $width            =    hexdec($header_parts[19].$header_parts[18]);
            $height            =    hexdec($header_parts[23].$header_parts[22]);
            unset($header_parts);
        }
        $x                =    0;
        $y                =    1;
        $image            =    imagecreatetruecolor($width,$height);
        $body            =    substr($hex,108);
        $body_size        =    (strlen($body)/2);
        $header_size    =    ($width*$height);
        $usePadding        =    ($body_size>($header_size*3)+4);
        for ($i=0;$i<$body_size;$i+=3)
        {
            if ($x>=$width)
            {
                if ($usePadding)
                    $i    +=    $width%4;
                $x    =    0;
                $y++;
                if ($y>$height)
                    break;
            }
            $i_pos    =    $i*2;
            $r        =    hexdec($body[$i_pos+4].$body[$i_pos+5]);
            $g        =    hexdec($body[$i_pos+2].$body[$i_pos+3]);
            $b        =    hexdec($body[$i_pos].$body[$i_pos+1]);
            $color    =    imagecolorallocate($image,$r,$g,$b);
            imagesetpixel($image,$x,$height-$y,$color);
            $x++;
        }
        unset($body);
        return $image;
    }
}
