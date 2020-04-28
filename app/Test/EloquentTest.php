<?php
namespace Test\Eloquent;
use App\Eloquents\M_Groupusers;
use PHPUnit\Framework\TestCase;

class EloquentTest extends TestCase {
    public function testData()
    {
        $g = new M_Groupusers();
        $g->Username = "Admin";

        $this->assertInstanceOf(
            $g->Username,
            M_Groupusers::find(1)->Username
        );
    }

}