<?php
namespace Addons\Payment\Controller;

use Home\Controller\AddonsController;

class AlipayController extends AddonsController
{

    public $token;

    public $wecha_id;

    public $alipayConfig;

    public function __construct()
    {
        parent::__construct();
        
        $this->token = get_token();
        $this->wecha_id = get_openid();
        
        // 读取配置
        $alipay_config_db = M('payment_set');
        $this->alipayConfig = $alipay_config_db->where(array(
            'token' => $this->token
        ))->find();
    }

    public function pay()
    {
        header("Content-type: text/html; charset=utf-8");
        // 参数数据
        // 订单名称,没有取当前 Unix 时间戳和微秒数
        $orderName = $_GET['orderName'];
        $orderid = $_GET['orderid'];        
        $price = $_GET['price'];
        $addon = $_GET['addon'];
        //$from = isset($_GET['from']) ? $_GET['from'] : 'shop';
        //
        $from = $_GET['from'];
        $alipayConfig = $this->alipayConfig;
        //
        if (! $price) {
            exit('必须有价格才能支付');
        }
        
        $paytype = I('get.paytype', 0, 'intval');
        $config = getAddonConfig('Payment');
        
        if ($config["isopen"] == 0) {
            exit("支付功能未启用!");
        }
        switch ($paytype) {
            default:
                $alipayConfig['paytype'] = 'Alipaytype';
                if ($config["isopenzfb"] == 0) {
                    exit("支付宝支付功能未启用!");
                }
                break;
            case 1:
                $alipayConfig['paytype'] = 'Alipaytype';
                if ($config["isopenzfb"] == 0) {
                    exit("支付宝支付功能未启用!");
                }
                break;
            case 2:
                $alipayConfig['paytype'] = 'Tenpay';
                if ($config["isopencftwap"] == 0) {
                    exit("财付通WAP支付功能未启用!");
                }
                break;
            case 0:
                $alipayConfig['paytype'] = 'Weixin';
                if ($config["isopenwx"] == 0) {
                    exit("微信支付功能未启用!");
                }
                break;
            case 5:
                $alipayConfig['paytype'] = 'WeixinV3';
                if ($config["isopenwxv3"] == 0) {
                    exit("微信支付V3版功能未启用!");
                }
                break;
            case 3:
                $alipayConfig['paytype'] = 'TenpayComputer';
                if ($config["isopencft"] == 0) {
                    exit("财付通支付功能未启用!");
                }
                break;
            case 4:
                $alipayConfig['paytype'] = 'Quickpay';
                if ($config["isopenyl"] == 0) {
                    exit("银联支付功能未启用!");
                }
                break;
        }
        
        $payArray = array(
            'from' => $from,
            'orderName' => $orderName,
            'single_orderid' => $orderid,
            'price' => $price,
            'paytype' => $zftype,
            'addon' => $addon
        );
        if ($alipayConfig['paytype'] == 'Weixin' || $alipayConfig['paytype'] == 'WeixinV3') {
            $payArray['showwxpaytitle'] = 1;
        }
        $url = addons_url("Payment://" . $alipayConfig['paytype'] . "/pay", $payArray);
        header('Location:' . $url);
    }
}
?>