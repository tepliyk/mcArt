<?

new Primes();

class Primes
{
    private $filename = '';
    private $inputFilename = '';

    private $num = 0;
    private $sqrt = 0;

    private $primes = array();

    public function __construct($inputFilename = 'in.txt', $filename = 'out.txt')
    {
        $this->filename = $filename;
        $this->inputFilename = $inputFilename;

        $this->setDataArray();
        $this->benchmark();
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
                $this->num = intval(trim($buffer));
            }
            if (!feof($handle))
            {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }

        if(empty($this->num)) echo 'Error: no data in file '.__DIR__ . DIRECTORY_SEPARATOR . $this->inputFilename;

        $this->sqrt = floor(sqrt($this->num));
    }

    private function findPrimes()
    {
        $sieve = str_repeat("\1", $this->num + 1);

        for ($i = 2; $i <= $this->sqrt; $i++)
        {
            if ($sieve[$i] === "\1")
            {
                for ($j = $i * $i; $j <= $this->num; $j += $i)
                {
                    $sieve[$j] = "\0";
                }
            }
        }

        $this->primes = array();
        for($i=2;$i<=$this->num;$i++) if(ord($sieve[$i])) $this->primes[]=$i;
    }

    private function benchmark(){
        $memory0 = memory_get_peak_usage();
        $time0   = microtime(TRUE);

        $this->findPrimes();

        $memory1 = memory_get_peak_usage();
        $time1   = microtime(TRUE);

        $delta_mem  = $memory1 - $memory0;
        $delta_time = $time1   - $time0;

        $bpe   = round($delta_mem / $this->num, 2);
        $mspe  = round(1000*$delta_time, 2);

        echo " $delta_mem b ($bpe b per element), $mspe ms <br>";
    }


    private function whiteDataArray()
    {
        echo implode(' ', $this->primes);

        $handle = @fopen(__DIR__ . DIRECTORY_SEPARATOR . $this->filename, "w");
        if ($handle)
        {
            @fwrite($handle, implode(' ', $this->primes));
            fclose($handle);
        }
    }


}

?>