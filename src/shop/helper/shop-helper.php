<?php
namespace Affilicious\Shop\Helper;

use Affilicious\Common\Helper\Time_Helper;
use Affilicious\Common\Model\Name;
use Affilicious\Common\Model\Slug;
use Affilicious\Shop\Model\Shop;
use Affilicious\Shop\Model\Shop_Template_Id;

if (!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

class Shop_Helper
{
    /**
     * Convert the shop into an array.
     *
     * @since 0.8
     * @param Shop $shop
     * @return array
     */
    public static function to_array(Shop $shop)
    {
        $array = array(
            'template_id' => $shop->get_template_id()->get_value(),
            'name' => $shop->get_name()->get_value(),
            'slug' => $shop->get_slug()->get_value(),
            'updated_at' => Time_Helper::to_datetime_i18n($shop->get_updated_at()),
            'thumbnail_id' => $shop->has_thumbnail_id() ? $shop->get_thumbnail_id()->get_value() : null,
            'tracking' => Tracking_Helper::to_array($shop->get_tracking()),
            'pricing' => Pricing_Helper::to_array($shop->get_pricing()),
        );

        $array = apply_filters('aff_shop_to_array', $array, $shop);

        return $array;
    }

    /**
     * Convert the array into a shop.
     *
     * @since 0.9
     * @param array $array
     * @return Shop
     */
    public static function from_array(array $array)
    {
        $name = new Name($array['name']);
        $slug = new Slug($array['slug']);
        $tracking = Tracking_Helper::from_array($array['tracking']);
        $pricing = Pricing_Helper::from_array($array['pricing']);

        $shop = new Shop($name, $slug, $tracking, $pricing);

        if(!empty($array['template_id'])) {
            $shop->set_template_id(new Shop_Template_Id($array['template_id']));
        }

        if(!empty($array['updated_at']) && $updated_at = Time_Helper::to_datetime_immutable_object($array['updated_at'])) {
            $shop->set_updated_at($updated_at);
        }

        $shop = apply_filters('aff_array_to_shop', $shop, $array);

        return $shop;
    }
}
