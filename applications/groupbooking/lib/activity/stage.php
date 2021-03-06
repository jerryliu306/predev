<?php

class groupbooking_activity_stage {

    public function __construct($app)
    {
        $this->app = $app;
    }
    /*
     * 丰富拼团活动基础信息
     * */
    public function gallery(&$activity_list) {
        $mdl_product = app::get('b2c')->model('products');
        if(!$pids = array_keys(utils::array_change_key($activity_list, 'product_id'))) {
            return false;
        };
        $filter_products = array(
            'product_id' => $pids,
            'marketable' => 'true',
        );
        $time = time();
        if($product_list = $mdl_product->getList('*',$filter_products)) {
            $product_list  = utils::array_change_key($product_list,'product_id');
            foreach($activity_list as &$activity) {
                $activity = array_merge($activity['conditions'][$activity['product_id']],$activity);
                $order['surplus_time'] = $activity['end_time']-$time;
                $activity['product'] = $product_list[$activity['product_id']];
            }
        };
        return true;
    }

}