<?

abstract class CDish {
    public abstract function getCost();
    public abstract function getName();
}

class СBorsch extends CDish {
    public function getCost()
    {
        return 50;
    }

    public function getName()
    {
        return 'Борщ';
    }
}

class СPyure extends CDish {
    public function getCost()
    {
        return 25;
    }

    public function getName()
    {
        return 'Картфельное пюре';
    }
}

class СPyureSKetchupom extends CDish {
    public function getCost()
    {
        return 25 + 1;
    }

    public function getName()
    {
        return 'Картфельное пюре (кетчуп)';
    }
}

class СPyureSKetchupomIHlebom extends CDish {
    public function getCost()
    {
        return 25 + 1 + 1;
    }

    public function getName()
    {
        return 'Картфельное пюре (кетчуп, хлеб)';
    }
}

class СPyureSKetchupomIHlebom2 extends CDish {
    public function getCost()
    {
        return 25 + 1 + 1*2;
    }

    public function getName()
    {
        return 'Картфельное пюрэ (кетчуп, хлеб x 2)';
    }
}

class СFri extends CDish {
    public function getCost()
    {
        return 30;
    }

    public function getName()
    {
        return 'Картофель фри';
    }
}

class СBliny extends CDish {
    public function getCost()
    {
        return 30;
    }

    public function getName()
    {
        return 'Блины';
    }
}

class СOlivie extends CDish {
    public function getCost()
    {
        return 30;
    }

    public function getName()
    {
        return 'Салат оливье';
    }
}

class СShashlyk extends CDish {
    public function getCost()
    {
        return 50;
    }

    public function getName()
    {
        return 'Шашлык';
    }
}

class СChaiChyornyy extends CDish {
    public function getCost()
    {
        return 20;
    }

    public function getName()
    {
        return 'Чёрный чай';
    }
}

class CKofe extends CDish {
    public function getCost()
    {
        return 20;
    }

    public function getName()
    {
        return 'Кофе';
    }
}

?>