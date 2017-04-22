<?

include 'out.php';

// вывести список и стоимость для заказа:
// - котлета
// - 3 пюрэ с кетчупом и 2 кусочками хлеба
// - чёрный чай с 2 лимонами
// - 2 зелёных чая

$arOrder = array();

$arOrder[] = new CKotleta();
$arOrder[] = new CPyure(3, array(new CKetchup(), new CHleb(2)));
$arOrder[] = new CChaiChyornyy(1, array(new CLimon(2)));
$arOrder[] = new CChaiZelenyy(2);

$cost = 0;
foreach($arOrder as $dish)
{
    echo '<pre>'.$dish->getName().' - '.$dish->getCost().'</pre>';
    $cost += $dish->getCost();
}
echo '<pre>итого: '.$cost.'</pre>';

?>