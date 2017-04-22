<?
new DrawCaptcha();

class DrawCaptcha
{
    private $filename = '';

    private $baseImage;
    private $width = 400;
    private $height = 300;
    private $radius = 140;

    private $dataArray = array();
    private $vocabulary = array();

    // �����
    private $arColors = array();

    public function __construct($filename = 'out.png')
    {
        $this->filename = $filename;

        // ������ ��������
        $this->baseImage = @imagecreatetruecolor($this->width, $this->height);

        // �����
        $bgcolor = ImageColorAllocate($this->baseImage, rand(200, 255), rand(200, 255), rand(200, 255));

        //���
        imagefill($this->baseImage, 0, 0, $bgcolor);

        $this->setDataArray();
        $this->drawCaptcha();

        //����� � �������
        header("Content-Type: image/png");
        imagepng($this->baseImage);
        //imagepng ($this->baseImage, __DIR__ . DIRECTORY_SEPARATOR . $this->filename);

        imagedestroy($this->baseImage);
    }

    private function setDataArray()
    {
        $this->dataArray = array();

        $handle = @fopen(__DIR__ . DIRECTORY_SEPARATOR . 'vocabulary.txt', "r");

        if ($handle) {
            $i = 0;
            while (($buffer = fgets($handle, 4096)) !== false) {
                $this->vocabulary[$i++] = explode(';', trim($buffer));
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }

        if (empty($this->vocabulary)) echo 'Error: no data in file ' . __DIR__ . DIRECTORY_SEPARATOR . 'vocabulary.txt';


        // ����
        $hours = intval(date('g'));
        $hname = $this->vocabulary[$hours][array_rand($this->vocabulary[$hours])];
        if ($hours == 12) $hours = 0;
        $hours -= 3;
        $hours = -$hours;
        $this->dataArray[$hname] = $hours * 30;

        // ������
        $minutes = intval(date('i'));
        $hminutes = $this->vocabulary[$minutes % 21][array_rand($this->vocabulary[$minutes % 21])];
        $minutes -= 15;
        $minutes = -$minutes;
        $this->dataArray[$hminutes] = $minutes * 6;

        // �������
        $seconds = intval(date('s'));
        $hseconds = $this->vocabulary[$seconds % 21][array_rand($this->vocabulary[$seconds % 21])];
        $seconds -= 15;
        $seconds = -$seconds;
        $this->dataArray[$hseconds] = $seconds * 6;
    }

    private function setColors($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $r = rand(0, 200);
            $g = rand(0, 200);
            $b = rand(0, 200);

            $this->arColors[$i] = ImageColorAllocate($this->baseImage, $r, $g, $b);
        }
    }

    private function drawCaptcha()
    {
        $linenum = 0;

        $this->setColors(count($this->dataArray) + 1);

        $center = array(
            'x' => round($this->width / 2),
            'y' => round($this->height / 2)
        );

        $fontSrc = __DIR__ . "/fonts/gothaproreg-webfont.ttf";
        $fontSizeMax = 28;

        imageellipse($this->baseImage, $center['x'], $center['y'], $this->radius * 2, $this->radius * 2, $this->arColors[0]);

        for ($i = 0; $i < $linenum; $i++) {
            $color = imagecolorallocate($this->baseImage, rand(50, 150), rand(50, 150), rand(50, 150)); // ��������� ���� c �����������
            imageline($this->baseImage, rand(0, 20), rand(1, $this->height - 30), rand($this->width - 20, $this->width), rand(1, $this->height), $color);
        }

        $i = 1;
        foreach ($this->dataArray as $name => $angle) {
            if (strlen($name) > 5) $fontSize = $fontSizeMax * (20 - strlen($name)) / 20;
            else $fontSize = $fontSizeMax;
            imagettftext($this->baseImage, $fontSize, $angle, $center['x'] - 5, $center['y'], $this->arColors[$i++], $fontSrc, $name);
        }

    }

}

?>