<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property string $path
 * @property string $description
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'description' => 'Description',
        ];
    }

    public static function findByPath($path)
    {
        return parent::find()->where(['=', 'path', $path])->one();
    }

    public static function findOrCreateByPath($path)
    {
        $res = self::findByPath($path);
        if ($res) {
            return $res->id;
        }
        $newImage = new Images();
        $newImage->path = $path;

        if ($newImage->save()) return $newImage->id;
        return null;

    }

    public static function imgResize($path, $size)
    {
        $type = exif_imagetype($path);
        //echo "ТИП=".$type."\n";
        // исходное изображение
        $source = $path;
        $new_file = str_replace("uploads/", "uploads/min/" . $size . "/", $path);
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
        $new_height = !$use_x_ratio ? $height :
            floor($size[1] * $ratio);
// расхождение с заданными параметрами по ширине
        $new_left = $use_x_ratio ? 0 :
            floor(($width - $new_width) / 2);
// расхождение с заданными параметрами по высоте
        $new_top = !$use_x_ratio ? 0 :
            floor(($height - $new_height) / 2);
// создаем холст пропорциональное сжатой картинке
        $img = imagecreatetruecolor($width, $height);
// делаем его прозрачным
        imagesavealpha($img, true);
        imagealphablending($img, false);
        $trans_colour = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $trans_colour);
// загружаем исходную картинку
        if ($type == 3) {
            $photo = imagecreatefrompng($source);
        } elseif ($type == 2) {
            $photo = imagecreatefromjpeg($source);
        } elseif ($type == 1) {
            $photo = imagecreatefromgif($source);
        } elseif ($type == 6) {
            $photo = Images::imagecreatefrombmp($source);
        }
        if ($type != 3 && $type != 2 && $type != 1) {
            return 0;
        }


// копируем на холст сжатую картинку
// с учетом расхождений
        imagecopyresampled($img, $photo, $new_left, $new_top,
            0, 0, $new_width, $new_height, $size[0], $size[1]);
// сохраняем результат
        imagepng($img, $new_file);
// очищаем память после выполнения скрипта
        imagedestroy($img);
        imagedestroy($photo);
    }

    public static function iconResize($path, $size)
    {
        $type = exif_imagetype($path);
        //echo "ТИП=".$type."\n";
        // исходное изображение
        $source = $path;
        $new_file = str_replace("uploads/icons/", "uploads/icons/min/" . $size . "/", $path);
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
        $new_height = !$use_x_ratio ? $height :
            floor($size[1] * $ratio);
// расхождение с заданными параметрами по ширине
        $new_left = $use_x_ratio ? 0 :
            floor(($width - $new_width) / 2);
// расхождение с заданными параметрами по высоте
        $new_top = !$use_x_ratio ? 0 :
            floor(($height - $new_height) / 2);
// создаем холст пропорциональное сжатой картинке
        $img = imagecreatetruecolor($width, $height);
// делаем его прозрачным
        imagesavealpha($img, true);
        imagealphablending($img, false);
        $trans_colour = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $trans_colour);
// загружаем исходную картинку
        if ($type == 3) {
            $photo = imagecreatefrompng($source);
        } elseif ($type == 2) {
            $photo = imagecreatefromjpeg($source);
        } elseif ($type == 1) {
            $photo = imagecreatefromgif($source);
        } elseif ($type == 6) {
            $photo = Images::imagecreatefrombmp($source);
        }
        if ($type != 3 && $type != 2 && $type != 1) {
            return 0;
        }


// копируем на холст сжатую картинку
// с учетом расхождений
        imagecopyresampled($img, $photo, $new_left, $new_top,
            0, 0, $new_width, $new_height, $size[0], $size[1]);
// сохраняем результат
        imagepng($img, $new_file);
// очищаем память после выполнения скрипта
        imagedestroy($img);
        imagedestroy($photo);
    }

    public static function imagecreatefrombmp($p_sFile)
    {
        $file = fopen($p_sFile, "rb");
        $read = fread($file, 10);
        while (!feof($file) && ($read <> ""))
            $read .= fread($file, 1024);
        $temp = unpack("H*", $read);
        $hex = $temp[1];
        $header = substr($hex, 0, 108);
        if (substr($header, 0, 4) == "424d") {
            $header_parts = str_split($header, 2);
            $width = hexdec($header_parts[19] . $header_parts[18]);
            $height = hexdec($header_parts[23] . $header_parts[22]);
            unset($header_parts);
        }
        $x = 0;
        $y = 1;
        $image = imagecreatetruecolor($width, $height);
        $body = substr($hex, 108);
        $body_size = (strlen($body) / 2);
        $header_size = ($width * $height);
        $usePadding = ($body_size > ($header_size * 3) + 4);
        for ($i = 0; $i < $body_size; $i += 3) {
            if ($x >= $width) {
                if ($usePadding)
                    $i += $width % 4;
                $x = 0;
                $y++;
                if ($y > $height)
                    break;
            }
            $i_pos = $i * 2;
            $r = hexdec($body[$i_pos + 4] . $body[$i_pos + 5]);
            $g = hexdec($body[$i_pos + 2] . $body[$i_pos + 3]);
            $b = hexdec($body[$i_pos] . $body[$i_pos + 1]);
            $color = imagecolorallocate($image, $r, $g, $b);
            imagesetpixel($image, $x, $height - $y, $color);
            $x++;
        }
        unset($body);
        return $image;
    }
}
