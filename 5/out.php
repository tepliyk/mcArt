<?

abstract class CSellItem
{
    protected $quantity;
    protected $cost;
    protected $name;
    protected $maxQuantity;

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity = 1)
    {
        $this->quantity = $quantity;
    }

    public function getCost()
    {
        return $this->quantity * $this->cost;
    }

    public function getName()
    {
        if($this->quantity < 1) return false;

        $n = $this->name;
        if($this->quantity > 1) $n .= ' x '.$this->quantity;
        return $n;
    }

    public function quantityUp()
    {
        if(!empty($this->maxQuantity))
        {
            if($this->quantity < $this->maxQuantity) $this->quantity++;
        }
        else
        {
            $this->quantity++;
        }

        return $this->quantity;
    }

    public function quantityDown()
    {
        if($this->quantity > 0) $this->quantity--;
        return $this->quantity;
    }
}


class CKetchup extends CSellItem {

    public function __construct($quantity = 1)
    {
        $this->quantity = $quantity;
        $this->name = 'кетчуп';
        $this->cost = 1;
        $this->maxQuantity = 1;
    }
}

class CHleb extends CSellItem {

    public function __construct($quantity = 1)
    {
        $this->quantity = $quantity;
        $this->name = 'хлеб';
        $this->cost = 1;
    }
}

class CLimon extends CSellItem {

    public function __construct($quantity = 1)
    {
        $this->quantity = $quantity;
        $this->name = 'лимон';
        $this->cost = 1;
    }
}


/*------- БЛЮДА --------*/

abstract class CDish extends CSellItem
{
    protected $dobavki = array();
    protected $availableDobavki;

    public function getName()
    {
        $n = $this->name;
        if (!empty($this->dobavki))
        {
            foreach ($this->dobavki as $dob)
            {
                if ($dn = $dob->getName())
                {
                    $arDobNames[] = $dn;
                }
            }
        }

        if (!empty($arDobNames)) $n .= ' (' . implode(', ', $arDobNames) . ')';

        if($this->quantity > 1) $n .= ' x '.$this->quantity;

        return $n;
    }

    public function getCost()
    {
        $c = parent::getCost();
        if (!empty($this->dobavki))
        {
            foreach ($this->dobavki as $dob)
            {
                if ($dc = $dob->getCost())
                {
                    $c += $dc * $this->quantity;
                }
            }
        }

        return $c;
    }

    public function addDobavka($do)
    {
        if(in_array(get_class($do), $this->availableDobavki))
        {
            $this->dobavki[] = $do;
            return true;
        }
        return false;
    }

}

class CPyure extends CDish
{

    public function __construct($quantity = 1, $arDob = array())
    {
        $this->quantity = $quantity;
        $this->name = 'Картофельное пюре';
        $this->cost = 25;
        $this->availableDobavki = array('CKetchup', 'CHleb');
        foreach($arDob as $d) $this->addDobavka($d);
    }
}

class CFri extends CDish
{
    public function __construct($quantity = 1, $arDob = array())
    {
        $this->quantity = $quantity;
        $this->name = 'Картофель фри';
        $this->cost = 30;
        $this->availableDobavki = array('CKetchup');
        foreach($arDob as $d) $this->addDobavka($d);
    }
}

class CKotleta extends CDish
{
    public function __construct($quantity = 1, $arDob = array())
    {
        $this->quantity = $quantity;
        $this->name = 'Котлета';
        $this->cost = 50;
        $this->availableDobavki = array('CKetchup');
        foreach($arDob as $d) $this->addDobavka($d);
    }
}

class CChaiChyornyy extends CDish
{
    public function __construct($quantity = 1, $arDob = array())
    {
        $this->quantity = $quantity;
        $this->name = 'Чёрный чай';
        $this->cost = 20;
        $this->availableDobavki = array('CLimon');
        foreach($arDob as $d) $this->addDobavka($d);
    }
}

class CChaiZelenyy extends CDish
{
    public function __construct($quantity = 1, $arDob = array())
    {
        $this->quantity = $quantity;
        $this->name = 'Злёный чай';
        $this->cost = 20;
        $this->availableDobavki = array();
        foreach($arDob as $d) $this->addDobavka($d);
    }
}

?>