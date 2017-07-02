<?php

namespace console\controllers;
use yii\helpers\Console;
use common\models\Os;
use common\models\Os_links;
use common\models\OsNew;
use common\models\OsLinksNew;
use common\models\Products;
use Yii;

class TableController extends \yii\Console\Controller
{
    public function actionParseros()
    {
        $allOs=Os::find()->all();
        foreach($allOs as $os)
        {
            $newName=array();
            preg_match_all('/Windows (.*)/', $os->name, $arrOs);
            if(!empty($arrOs[1])){
               $newName=explode ('/',$arrOs[1][0] );
                for($i=0; $i<sizeof($newName); $i++)
                {
                    $newName[$i]= "Windows ".$newName[$i];
                }

            }
            else
            {
                $newName[0]=$os->name;
            }
            foreach($newName as $newOs)
            {
                if(OsNew::find()->where(['=', 'name', $newOs])->one()==NULL)
                {
                    $OsNew=new OsNew();
                    $OsNew->name=$newOs;
                    $OsNew->save();
                }
                //die;
            }
        }
    }
    public function actionParseroslinks()
    {
        $allNewOs=OsNew::find()->all();
        //var_dump($allProd);
        foreach($allNewOs as $allNew)
        {
            $allOs=Os::find()->all();
            foreach($allOs as $os)
            {
                $newName=array();
                preg_match_all('/Windows (.*)/', $os->name, $arrOs);
                if(!empty($arrOs[1])){
                    $newName=explode ('/',$arrOs[1][0] );
                    for($i=0; $i<sizeof($newName); $i++)
                    {
                        $newName[$i]= "Windows ".$newName[$i];
                    }

                }
                else
                {
                    $newName[0]=$os->name;
                    echo("\nnewName[0]=os->name; ".$os->name);

                }
               //
                foreach($newName as $name)
                {
                    echo("\nNew Name ".$name ."  allNew->name = ".$allNew->name);
                   if($name==$allNew->name)
                   {
                       echo("\nallNew->name ".$allNew->name );

                       $oldOsLinks=Os_links::find()->where(['=', 'os_id', $os->id])->all();
                       //var_dump($oldOsLinks);
                       //die();
                       foreach($oldOsLinks as $oldOsLink)
                       {

                            $newOsLink= new OsLinksNew();
                            $newOsLink->product_id=$oldOsLink->product_id;
                            $newOsLink->os_id=$allNew->id;
                           if (!$newOsLink->validate()) {
                               var_dump($newOsLink->errors);
                               continue;
                           }
                            $newOsLink->save();
                           echo("\nnewOsLink->save() ");
                       }
                       //die();
                   }
                }
            }
           // die();
        }
    }
}
