<?php
/**
 * Created by PhpStorm.
 * User: ming123jew
 * Date: 2018-4-17
 * Time: 10:51
 */

/**
 * 策略模式，将一组特定的行为和算法封装成类，以适应某些特定的上下文环境。
 * eg：假如有一个电商网站系统，针对男性女性用户要各自跳转到不同的商品类目，并且所有的广告位展示不同的广告。在传统的代码中，都是在系统中加入各种if else的判断，硬编码的方式。如果有一天增加了一种用户，就需要改写代码。使用策略模式，如果新增加一种用户类型，只需要增加一种策略就可以。其他所有的地方只需要使用不同的策略就可以。
 * 首先声明策略的接口文件，约定了策略的包含的行为。然后，定义各个具体的策略实现类。
 * Class Strategy
 */
/**
 * 声明策略文件的接口，约定策略包含的行为。
 */
interface Strategy
{
    function showAd();
    function showCategory();
}