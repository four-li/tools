<?php
/**                                                             ";
 * date: 2019/8/3
 * author: four-li
 */

namespace FourLi\Tools\QrCode;


class ApiQrcode
{
    private $appcode;

    public function __construct(string $appcode)
    {
        $this->appcode = $appcode;
    }

    private function base64EncodeImage($image_file)
    {
        $image_info   = getimagesize($image_file);
        $image_data   = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }

    /**
     * - i.e. 解析二维码 支持本地文件和在线图片url
     * - e.g.
     *
     * @param string $imgPath
     * @return string
     */
    public function reader(string $imgPath)
    {
        if (!inStr('http', $imgPath)) {
            $bodys = $this->formatUrlParameter([
                'imgdata' => $this->base64EncodeImage($imgPath),
                'version' => 1.1,
            ]);
        } else {
            $bodys = $this->formatUrlParameter([
                'imgurl'  => $imgPath,
                //            'imgdata' => '',
                'version' => 1.1,
            ]);
        }

        $host    = "http://qrapi.market.alicloudapi.com";
        $path    = "/yunapi/qrdecode.html";
        $method  = "POST";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $this->appcode);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type" . ":" . "application/x-www-form-urlencoded; charset=UTF-8");

        $url  = $host . $path;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
        $ret = curl_exec($curl);

        try {
            $text = json_decode($ret, true)['data']['raw_text'];
            return $text;
        } catch (\Exception $e) {
            return false;
        }
    }

    private $size = 300;

    /**
     * - i.e. 设置宽度
     * - e.g.
     *
     * @param int $widthPx
     * @return $this
     */
    public function setSize(int $widthPx = 300)
    {
        $this->size = $widthPx;

        return $this;
    }

    private $backColor = '#FFFFFF';
    private $foreColor = '#000000';


    /**
     * - i.e. 设置前景色（二维码）的颜色 一般二维码颜色是黑的
     * - e.g. 有无 # 号都可以
     *
     * @param $color
     * @return $this
     */
    public function setForegroundColor(string $color = '#000000')
    {
        $this->foreColor = $color;

        return $this;
    }

    /**
     * - i.e. 设置背景色（二维码后面的背景色 默认是白色背景）
     * - e.g. 有无 # 号都可以
     *
     * @param     $color
     * @return $this
     */
    public function setBackgroudColor(string $color = '#FFFFFF')
    {
        $this->backColor = $color;

        return $this;
    }

    private $logo = null;

    /**
     * - i.e. 设置logo 注意logo必须是远程图片地址 大小不超过 50 KB
     * - e.g.
     *
     * @param string $logo
     * @param int    $width
     * @param int    $height
     * @return $this
     */
    public function setLogo(string $logo, int $width = 100, int $height = 100)
    {
        $this->logo = [
            'logo'  => $logo,
            'wlogo' => $width,
            'hlogo' => $height
        ];
        return $this;
    }

    private $savePath;

    public function download($fileName = 'qrcode.png')
    {
        $this->outputDownload($this->savePath, $fileName);

        return true;
    }

    public function generator(string $text, string $savePath)
    {
        $this->savePath = $savePath;

        $param = [
            'qrdata'     => $text,
            'size'       => $this->size,
            'xt'         => 1,
            'level'      => 'M',
            'p_color'    => '#000000',
            'i_color'    => '#000000',
            'back_color' => $this->backColor,
            'fore_color' => $this->foreColor,
            'version'    => '1.1'
        ];

        if ($this->logo) {
            $param = array_merge($param, $this->logo);
        }

        $body = $this->formatUrlParameter($param);

        $host    = "http://qrapi.market.alicloudapi.com";
        $path    = "/yunapi/qrencode.html";
        $method  = "POST";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $this->appcode);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type" . ":" . "application/x-www-form-urlencoded; charset=UTF-8");

        $url  = $host . $path;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        $ret = curl_exec($curl);

        $url = json_decode($ret, true)['data']['qr_filepath'];

        # 下载远程图片至服务器目录
        $data = $this->getRemoteImg($url);

        file_put_contents($savePath, $data);

        return $this;
    }

    /**
     * - i.e. 读取远程图片
     * - e.g.
     *
     * @param $url
     * @return mixed|string
     */
    private function getRemoteImg($url)//简洁版curl接口调用函数
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return 'ERROR' . curl_errno($curl);
        }
        curl_close($curl);
        return $data;
    }

    /**
     * 输出文件到浏览器
     *
     * @param string $filename 文件路径
     * @param string $title    输出的文件名
     * @return void
     */
    private function outputDownload($filename, $title)
    {
        $file = fopen($filename, "rb");
        Header("Content-type:  application/octet-stream ");
        Header("Accept-Ranges:  bytes ");
        Header("Content-Disposition:  attachment;  filename= $title");
        while (!feof($file)) {
            echo fread($file, 8192);
            ob_flush();
            flush();
        }
        fclose($file);
    }

    /**
     * - i.e. 格式化url请求参数 参数rowurlencode
     * - e.g.
     *
     * @param $data
     * @return string
     */
    private function formatUrlParameter($data)
    {
        $buff = "";
        foreach ($data as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . rawurlencode($v) . "&";
            }
        }

        $buff = trim($buff, "&");

        return $buff;
    }
}
