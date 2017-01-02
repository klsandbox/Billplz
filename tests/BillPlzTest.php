<?php

namespace Hamzahjamad\BillPlz;

class BillPlzTest extends \PHPUnit_Framework_TestCase
{
	protected $billplz;
	protected $bank_account = 626236364646;
	protected $collection_id = "fohi29f5"; 

	protected $bill_id;

    protected function setUp()
    {
    	//the token of logged user and false to use sandbox endpoint
        $this->billplz = new BillPlz( '975a7240-e58c-4f49-8a76-bccaace63648' , false);
    }

    public function titleProvider()
    {
    	return [["My Third API Collection"]];
    }

	
	 /**
     * @dataProvider titleProvider
     */
	public function testCreatingANewCollection($title)
	{
		//$title = "My Third API Collection";

		$response = $this->billplz->setCollection(['title'=>$title]);

		$this->assertEquals(strtoupper($title), $response['title']);
	}



	/**
     * @dataProvider titleProvider
     */
	public function testCreatingANewOpenCollection($title)
	{
		$data = [
			'title'=>$title,
			'description'=>'dfasdfasdfafd',
			'amount'=>100,
		];

		$response = $this->billplz->setOpenCollection($data);

		$this->assertEquals(strtoupper($title), $response['title']);
	}


	/**
     * @dataProvider titleProvider
     */
	public function testDeactivateCollection($title)
	{
		$response = $this->billplz->deactivateCollection($this->collection_id);

		$this->assertCount(0, $response);
	}


	/**
     * @dataProvider titleProvider
     */
	public function testactivateCollection($title)
	{
		$response = $this->billplz->activateCollection($this->collection_id);

		$this->assertCount(0, $response);
	}

	private function setBill()
	{
		$data = [
			"collection_id" => "gid6klwb",
			"description" => "esdfasdfa",
			"name" => "test",
			"email" => "test@example.com",
			"amount" => 300,
			"callback_url" => "https://test.com/test",
		];

		return $this->billplz->setBill($data);
	}


	public function testCreatingANewBill()
	{
		$response = $this->setBill();
		$this->assertEquals("test@example.com", $response['email']);
	}


	public function testgetABill()
	{
		$bill_response = $this->setBill();
		$response = $this->billplz->getBill($bill_response['id']);

		$this->assertEquals( "test@example.com", $response['email']);
	}


	public function testdeleteABill()
	{
		$bill_response = $this->setBill();

		$delete_response = $this->billplz->deleteBill($bill_response['id']);

		$this->assertCount(0, $delete_response);
	}


	public function testVerifyAccountMethodIsWorking()
	{
		$response = $this->billplz->verifyAccount($this->bank_account);

		$this->assertNotNull($response['name']);
	}

}