<?php
include (dirname(__FILE__)."/api/article/arcList.php");
include (dirname(__FILE__)."/api/car/carSort.php");

//推荐品牌
$topBrandData = getRecommendBrandList();


//推荐车型
$carModelData = getRemommendCarList('120','4');
//按价格
$carpriceLevelData = getCarPriceLevel();
//按驱动
$carCategoryData = getCarCategoryArray();


//特荐5篇文章
$specialArcArcData = getArcList('185,189,325,194,198,206,204,205,331,183,129,316,177,30,166,164,102,326,343','f','','','5','',5);
//最新车型
$carModelArcData = getArcListExt(190,'','','','8','',8);
//评测导购
$guideBuyData = getArcListExt('109,192,193','','','','8','',8);
//用车精选
$talksData = getArcListExt(194,'','','','8','',8);

//产业动态
$newNewsData = getArcListExt('186,187,188,193,195,196,197,199','','','','8','',8);

include (dirname(__FILE__)."/templets/index.htm");
?>
