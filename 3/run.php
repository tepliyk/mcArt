<?

new Fraction();

class Fraction
{
    private $filename = '';
    private $inputFilename = '';

    private $dataArray = array();

    /**
     * DrawDigramm constructor.
     * @param string $filename
     * @param string $inputFilename
     */
    public function __construct($inputFilename = 'in.txt', $filename = 'out.txt')
    {
        $this->filename = $filename;
        $this->inputFilename = $inputFilename;

        $this->setDataArray();
        $this->convertToFraction();
        $this->whiteDataArray();
    }

    private function setDataArray()
    {
        $this->dataArray = array();

        $handle = @fopen(__DIR__ . DIRECTORY_SEPARATOR . $this->inputFilename, "r");

        if ($handle)
        {
            while (($buffer = fgets($handle, 4096)) !== false)
            {
                $this->dataArray[trim($buffer)] = str_replace(',', '.', trim($buffer));
            }
            if (!feof($handle))
            {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }

        if(empty($this->dataArray)) echo 'Error: no data in file '.__DIR__ . DIRECTORY_SEPARATOR . $this->inputFilename;
    }

    private function gcd($a, $b)
    {
        if ($a == 0 || $b == 0)
            return abs( max(abs($a), abs($b)) );

        $r = $a % $b;
        return ($r != 0) ?
            $this->gcd($b, $r) :
            abs($b);
    }

    private function convertToFraction()
    {
        foreach($this->dataArray as $orig => &$new)
        {
            $mantissaStart = strpos($new, '.');
            if($mantissaStart !== false)
            {
                $int = intval($new);
                $mantissa = substr($new, $mantissaStart + 1);
                if(!empty($mantissa))
                {
                    $pow = strlen($mantissa);
                    $a = intval($mantissa);
                    $b = 1;
                    while($pow-- > 0) $b *= 10;

                    $nod = $this->gcd($a, $b);
                    $a /= $nod;
                    $b /= $nod;

                    if($int != 0)
                        $new = $int.' '.$a.'/'.$b;
                    else
                        $new = $a.'/'.$b;
                }
                else
                {
                    $new = intval($new);
                }
            }
            else
            {
                $new = intval($new);
            }

        }

    }


    private function whiteDataArray()
    {
        echo '<pre>$this->dataArray='.print_r($this->dataArray, true).'</pre>';

        $handle = @fopen(__DIR__ . DIRECTORY_SEPARATOR . $this->filename, "w");
        if ($handle)
        {
            foreach($this->dataArray as $orig => $new)
            {
                @fwrite($handle, $orig.' = '.$new."\n");
            }
            fclose($handle);
        }
    }


}

?>