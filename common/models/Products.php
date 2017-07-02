<?php
namespace common\models;

use Yii;
use andreykluev\shopbasket\behaviors\BasketProductBehavior;
use yii\db\Query;
use yii\web\Request;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $description
 * @property string $version
 * @property string $system_requirements
 * @property string $reviews
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property double $price
 * @property string $name
 */
class Products extends \yii\db\ActiveRecord
{
    //  public $categories;
    public $os;
    public $manufacturers;


    public static function tableName()
    {
        return 'products';
    }

    public static function findOrCreateByName($name)
    {
        $res = self::findByName($name);
        if ($res) {
            return $res->id;
        }
        $newProduct = new products();
        $newProduct->name = $name;

        if ($newProduct->save()) return $newProduct->id;
        return $newProduct;

    }

    public static function findByName($name)
    {
        return parent::find()->where(['=', 'name', $name])->one();
    }

    public static function CollFiltration()
    {

        if (!empty(Yii::$app->user->id)) {
            if ($rating = Rating::find()->where(['=', 'id_user', Yii::$app->user->id])->all() != NULL) {

                $query = new Query();
                $query->select('fr2.frendid
,fr1.prodid
,`rating3`.`rating` frendrating
from

(SELECT rating.id_product prodid from rating WHERE rating.id_user in

(
SELECT

                          `rating2`.`id_user`  frendid


                        FROM `rating`
                        left join `rating` `rating2` on  `rating`.`id_product`= `rating2`.`id_product` and `rating`.`id_user`<>`rating2`.`id_user`

                        WHERE
                        `rating`.`id_user`=1
                        group by  `rating`.`id_user` ,  `rating2`.`id_user`
    UNION
    SELECT 1

    )
 group by  rating.id_product
 )fr1
inner join
(
SELECT

                          `rating2`.`id_user`  frendid


                        FROM `rating`
                        left join `rating` `rating2` on  `rating`.`id_product`= `rating2`.`id_product` and `rating`.`id_user`<>`rating2`.`id_user`

                        WHERE
                        `rating`.`id_user`=' . Yii::$app->user->id . '
                        and `rating2`.`id_user` is not null
                        group by  `rating`.`id_user` ,  `rating2`.`id_user`
        UNION
    SELECT 1

    )fr2


    left join `rating` `rating3` on fr2.frendid =`rating3`.`id_user`  and fr1.prodid = `rating3`.`id_product`


ORDER BY fr2.frendid,fr1.prodid');
                $command = $query->createCommand();
                $rows = $command->queryAll();
                $sortedData = array();
                // var_dump($rows);

                foreach ($rows as $row) {
                    $sortedData[$row['frendid']]['id_product'][] = $row['prodid'];
                    if ($row['frendrating'] != NULL) {
                        $sortedData[$row['frendid']]['rating'][] = (int)$row['frendrating'];
                    } else {
                        $sortedData[$row['frendid']]['rating'][] = 0;
                    }
                    $sortedData[$row['frendid']]['id_user'] = $row['frendid'];
                }


                $user = $sortedData[Yii::$app->user->id]['rating'];
                $userProd = $sortedData[Yii::$app->user->id]['id_product'];
                foreach ($sortedData as $sort) {

                    if ((int)$sort['id_user'] != (int)Yii::$app->user->id) {
                        $resA[] = self::cosMeasure($user, $sort['rating']);
                        $friends[] = $sort['id_user'];
                    }
                }


                for ($i = 0; $i < sizeof($resA); $i++) {

                    for ($j = 0; $j < sizeof($user); $j++) {
                        $resAN[$i][$j] = $sortedData[$friends[$i]]['rating'][$j] * $resA[$i];


                    }


//
                }
                //echo 'общий-----<br>';
                // var_dump(($resAN));
                for ($j = 0; $j < sizeof($user); $j++) {

                    $col = array_column($resAN, $j);
                    //  var_dump(array_sum($col));
                    $summ[$j] = array_sum($col);
                }


                for ($j = 0; $j < sizeof($user); $j++) {
                    if ($user[$j] == 0) {

                        $result[$j] = $summ[$j] / array_sum($resA);

                        $prodIds[$j] = $userProd[$j];
                    }
                }
                //  var_dump($user, $userProd);

                //   echo "<br> RESULT ";

                array_multisort($result, SORT_DESC, $prodIds, SORT_DESC);

                $query = new Query();

                $query->select('
                 `products`.`id`, `products`.`description`, `products`.`price`, `products`.`name`
,(select AVG(rating.rating)  from rating WHERE products.id=rating.id_product) as rating
, `images`.`path`
FROM `products`

LEFT JOIN images_links ON images_links.product_id=products.id
LEFT JOIN `images` ON images.id=images_links.image_id

 WHERE products.id IN (' . implode(',', $prodIds) . ')
 GROUP BY `products`.`id`
                ');


                $command = $query->createCommand();
                //  die($command->sql);
                $rows = $command->queryAll();

                return $rows;


            } else {
                return self::Popular();
            }
        }
    }

    static function cosMeasure($arr, $arr2)
    {
        //var_dump($arr2);
        $f = 1;
        $s = 1;
        $numerator = 0;
        $denominator = 0;
        for ($i = 0; $i < sizeof($arr); $i++) {
            if ($arr[$i] != 0 && $arr2[$i] != 0) {
                $numerator += $arr[$i] * $arr2[$i];

            }
            if ($arr[$i] != 0) {
                $f *= $arr[$i];
            }
            if ($arr2[$i] != 0) {
                $s *= $arr2[$i];
            }

        }
        return $numerator / (sqrt($f) * sqrt($s));
    }

    public static function Popular()
    {

        $query = new Query();

        $query->select('products.id, products.description, products.price, products.name, AVG(rating.rating) as rating, images.path')->from('products, rating, images, images_links')->
        where('products.id=rating.id_product AND products.id=images_links.product_id AND images_links.image_id=images.id')->
        groupBy('rating.id_product')->
        orderBy('COUNT(*) - COUNT(DISTINCT rating.id_product) DESC');
        //  $query->select('products.name,products.id,products.price')
        // ->from('products')->leftJoin('rating','products.id=rating.id_product')->groupBy('rating.id_product')->
        //       orderBy('COUNT(rating.id_product) DESC');
        $command = $query->createCommand();


        $rows = $command->queryAll();
        return $rows;
        /*
         *продукты по убыванию кол-ва оценок
         * SELECT *,COUNT(rating.id_product) ff FROM products left join rating on products.id=rating.id_product GROUP BY rating.id_product ORDER BY COUNT(rating.id_product) DESC
        * $sql=  SELECT * FROM products, rating WHERE products.id=rating.id_product GROUP BY rating.id_product ORDER BY  COUNT(DISTINCT rating.id_product) DESC*/
    }

    public function behaviors()
    {
        return [
            BasketProductBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['status'], 'integer'],
            //[['created_at', 'updated_at'], 'safe'],
            [['price'], 'required'],
            [['price', 'oldprice'], 'number'],
            [['version', 'reviews', 'name'], 'string', 'max' => 255],
            [['description', 'system_requirements'], 'string'],
            [['image'], 'image', 'maxFiles' => 10],
            /*[['categories', 'manufacturers', 'os'], 'link'],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'description' => 'Описание',
            'version' => 'Версия',
            'system_requirements' => 'Системные требования',
            'reviews' => 'Обзоры',
            'status' => 'Статус',
            'created_at' => 'Добавлено:',
            'updated_at' => 'Изменено:',
            'price' => 'Цена',
            'categories' => 'Категории',
            'os' => 'ОС',
            'oslist' => 'Oslist',
            'manlist' => 'Manlist',
            'category' => 'Категория',
            'manufacturers' => 'Производители',
            'image' => 'Изображение',
            'images' => 'Изображения',
            'shares' => 'Акции',
            'shareicon' => 'иконка акции',
            'oldprice' => 'старая цена',
            'allshares' => 'allshares',
            'onshare' => 'Акционное предложение',
        ];
    }

    public function getRating()
    {
        if (!empty(Yii::$app->user->id)) {
            $rating = Rating::find()->where(['AND', ['=', 'id_user', (int)Yii::$app->user->id], ['=', 'id_product', $this->id]])->one();

            if ($rating != NULL)

                return $rating->rating;
        }
        return 3;
    }

    public function getShareicon()
    {
        //return $this->hasMany(Shares::className(), ['id' => 'id_share'])
        //  ->viaTable('shares_links', ['id_product' => 'id']);

        // $sh=$sh->icon;
        // die(var_dump($sh));
        return $this->hasMany(Images::className(), ['id' => 'sharesicon'])
            ->one()->path;


    }

    public function setRating($value)
    {
        die($value);
    }

    public function getCategory()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])
            ->viaTable('product_links', ['product_id' => 'id'])->one();
    }

    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])
            ->viaTable('product_links', ['product_id' => 'id']);
    }

    public function getImage()
    {
        return $this->hasMany(Images::className(), ['id' => 'image_id'])
            ->viaTable('images_links', ['product_id' => 'id'])->one()->path;
    }

    public function getImages()
    {
        return $this->hasMany(Images::className(), ['id' => 'image_id'])
            ->viaTable('images_links', ['product_id' => 'id']);
    }

    public function setImage($value)
    {
        return '';
    }

    public function getShares()
    {
        return $this->hasMany(Shares::className(), ['id' => 'id_share'])
            ->viaTable('shares_links', ['id_product' => 'id']);
    }

    public function getAllshares()
    {
        return $this->hasMany(Shares::className(), ['id' => 'id_share'])
            ->viaTable('shares_links', ['id_product' => 'id'])->all();
    }

    public function getSharesicon()
    {
        return $this->hasMany(Shares::className(), ['id' => 'id_share'])
            ->viaTable('shares_links', ['id_product' => 'id'])->one()->icon;
    }

    public function getManufacturers()
    {
        return $this->hasMany(Manufacturers::className(), ['id' => 'manufacturer_id'])
            ->viaTable('manufacturers_links', ['product_id' => 'id']);
    }

    public function setManufacturers($value)
    {
        $this->manufacturers = (integer)$value;
    }

    public function getManlist()
    {
        return $this->hasMany(Manufacturers::className(), ['id' => 'manufacturer_id'])
            ->viaTable('manufacturers_links', ['product_id' => 'id'])->all();
    }

    public function getOslist()
    {
        return $this->hasMany(Os::className(), ['id' => 'os_id'])
            ->viaTable('os_links', ['product_id' => 'id'])->all();
    }

    public function getOs()
    {
        return $this->hasMany(Os::className(), ['id' => 'os_id'])
            ->viaTable('os_links', ['product_id' => 'id']);
    }

    public function setOs($value)
    {
        $this->os = (integer)$value;
    }

    public function AddUrl($urlEnter)
    {
        $url = new Url();
        $check = $url->find()->where("url=:urlEnter", [":urlEnter" => $urlEnter])->exists();
        if (!$check) {
            $url->url = $urlEnter;
            $url->save();

            return 0;

        } else {
            return 1;
        }

    }

    public function AddOsLinks($platform)
    {
        if ($this->id > 0)
            $this->save();

        foreach ($platform as $opS) {
            $lastOsId = Os::findOrCreateByName($opS);
            echo '$lastOsId=' . $lastOsId . "\n";
            Os_links::findOrCreateByLink($this->id, $lastOsId);
        }
    }

    public function AddImagesLinks($images)
    {
        if ($this->id > 0)
            $this->save();


        $lastImageId = Images::findOrCreateByPath($images);
        Images_links::findOrCreateByLink($this->id, $lastImageId);

    }

    public function AddManufacturersLinks($manufacturer)
    {
        if ($this->id > 0)
            $this->save();

        //foreach($platform as $opS)
        //{
        $lastOsId = Manufacturers::findOrCreateByName($manufacturer);
        Manufacturers_links::findOrCreateByLink($this->id, $lastOsId);
        //}
    }

    public function AddProductLinks($category)
    {
        if ($this->id > 0)
            $this->save();

        // foreach($platform as $opS)
        //{
        $lastCategoryId = Categories::findOrCreateByName($category);
        Product_links::findOrCreateByLink($this->id, $lastCategoryId);
        //}
    }

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);
        // die(print_r($changedAttributes));
        $post = Yii::$app->request->post();

        if (!empty($post['Products'])) {


            if (!empty($post['Products']["category"])) {
                $lastCategoryId = Categories::findOrCreateByName($post['Products']["category"]);
                Product_links::findOrCreateByLink($this->id, $lastCategoryId);
            }

            if (!empty($post['Products']["os"])) {
                $lastOsId = Os::findOrCreateByName($post['Products']["os"]);
                Os_links::findOrCreateByLink($this->id, $lastOsId);
            }

            if (!empty($post['Products']["manufacturers"])) {
                $lastOsId = Manufacturers::findOrCreateByName($post['Products']["manufacturers"]);
                Manufacturers_links::findOrCreateByLink($this->id, $lastOsId);
            }
            if (!empty($post['Products']["image"])) {
                // $lastOsId=Manufacturers::findOrCreateByName($post['Products']["manufacturers"]);
                //Manufacturers_links::findOrCreateByLink($this->id,$lastOsId);
            }
        }
    }

}
