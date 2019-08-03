<?php
/**                                                             ";
 * date: 2019/8/3
 * author: four-li
 */

namespace FourLi\Tools\QrCode;


use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Zxing\QrReader;

class PhpQrcode
{

    private $qrCode;

    private $savePath;

    public function __construct()
    {
        $this->qrCode = new QrCode();
        $this->qrCode->setEncoding('UTF-8');
        $this->qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH));
    }

    public function setLogo(string $logoPath, int $width = 80, int $height = 80)
    {
        $qrCode = $this->qrCode;

        try {
            $qrCode->setLogoPath($logoPath);
            $qrCode->setLogoSize($width, $height);
        } catch (\Exception $exception) {

        }
        return $this;
    }

    /**
     * - i.e. 设置边距
     * - e.g.
     *
     * @param int $marginPx
     * @return $this
     */
    public function setMargin(int $marginPx)
    {
        $this->qrCode->setMargin($marginPx);
        return $this;
    }

    private $colorConvert
        = [
            'white'  => [255, 255, 255],
            'black'  => [0, 0, 0],
            'red'    => [255, 0, 0],
            'yellow' => [255, 255, 0],
            'green'  => [0, 255, 0],
            'blue'   => [0, 0, 255],
            'purple' => [255, 0, 255],
            'gray'   => [128, 138, 135]
        ];

    /**
     * - i.e. 设置前景色（二维码）的颜色 一般二维码颜色是黑的
     * - e.g. 可选[ white, black, red, green, yellow, blue, purple, gray]
     *
     * @param $color
     * @return $this
     */
    public function setForegroundColor(string $color = 'black')
    {
        $property   = $this->colorConvert[$color];
        $colorParam = [
            'r' => $property[0],
            'g' => $property[1],
            'b' => $property[2],
            'a' => 0, // 透明度 0 ~ 1
        ];
        $this->qrCode->setForegroundColor($colorParam);

        return $this;
    }

    /**
     * - i.e. 设置背景色（二维码后面的背景色 默认是白色背景）
     * - e.g. color 可选[ white, black, red, green, yellow, blue, purple, gray]
     *
     * @param     $color
     * @return $this
     */
    public function setBackgroudColor(string $color = 'white')
    {
        $property   = $this->colorConvert[$color];
        $colorParam = [
            'r' => $property[0],
            'g' => $property[1],
            'b' => $property[2],
            'a' => 0, // 透明度 0 ~ 1
        ];
        $this->qrCode->setBackgroundColor($colorParam);

        return $this;
    }

    /**
     * - i.e. 设置宽度
     * - e.g.
     *
     * @param int $widthPx
     * @return $this
     */
    public function setSize(int $widthPx = 300)
    {
        $this->qrCode->setSize($widthPx);

        return $this;
    }

    /**
     * - i.e. 解析二维码 注意该库不能解析乱七八糟颜色的二维码
     * - e.g.
     *
     * @param $imgPath
     * @return mixed
     */
    public function reader(string $imgPath)
    {
        $qrcode = new QrReader($imgPath);

        return $qrcode->text();
    }

    public function download($fileName = 'qrcode.png')
    {
        $this->outputDownload($this->savePath, $fileName);

        return true;
    }

    public function generator(string $text, string $savePath)
    {
        $qrCode = $this->qrCode;

        $this->savePath = $savePath;

        $qrCode->setText($text);

        header('Content-Type: ' . $this->qrCode->getContentType());

        $qrCode->writeFile($savePath);

        return $this;
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
}
