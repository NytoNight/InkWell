<?php

spl_autoload_register(function ($class){
    $arr=['goods','interfaces','orders','reviews','serve','customer'];
    foreach ($arr as $val) {
        $path=__DIR__."/../$val/$class.php";
        if (file_exists($path))
            require_once $path;
    }
});

class OrdersTest
{

    public function testDeleteOrderDetails()
    {
        $b1=new Book(22,'a1',4556,150,170,'k','jn',140,140);
        $b2=new Book(33,'a2',4556,150,170,'k','jn',150,150);
        $b3=new Book(44,'a3',4556,150,170,'k','jn',160,160);

        $a=new Address('egypt','cairo','sww','45j');
        $c1=new Customers(' muhammed',$a,'engam','045454','45564');
        $o1=new Orders($c1,null);
        $c2=new Customers('ahmed muhammed',$a,'engam','045454','45564');

        $o1->addOrderDetails($b1,20);
        $o1->addOrderDetails($b1,30);
         $o1->addOrderDetails($b2,15);
         $o1->deliver();
        foreach ($o1->getOrderDetails()  as $key=>$value){
            echo "this is the data of the detail of book of id $key the amount of order of this details 
            is". $value->getQuantity()."and the remain of this book is ".$value->getBook()->getQuantity().
                "the actual remain is ".$value->getBook()->getActualQuantity()."<br/>";
        }

    }

    public function testAddOrderDetails()
    {

    }

    public function testGetTotalPrice()
    {

    }

    public function testDeliver()
    {

    }
}
$test=new OrdersTest();
$test->testDeleteOrderDetails();