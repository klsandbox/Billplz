<?php

namespace Hamzahjamad\BillPlz;

class BillPlzTest extends \PHPUnit_Framework_TestCase
{



	protected $billplz;

	

    protected function setUp()
    {
    	//the token of logged user and false to use sandbox endpoint
        $this->billplz = new BillPlz( $this->readKeyFile()["TOKEN"] , false);
    }



    private function readKeyFile()
    {
    	$path =  __DIR__."/../secret-env-plain";

    	$secret_file = fopen( $path , "r") or die("Unable to open file!");
		
		$keys = [];

		while(! feof($secret_file))
		  {
		  	$line = fgets($secret_file);
		  	$separate_line = explode("=", $line);
		  	$keys[$separate_line[0]] = $separate_line[1];
		  }

		fclose($secret_file);

		$keys = array_filter(array_map('trim', $keys));

		return $keys;
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
			'description'=>substr( md5(rand()), 0, 7),
			'amount'=>100,
		];

		$response = $this->billplz->setOpenCollection($data);

		$this->assertEquals(strtoupper($title), $response['title']);
	}



	public function testDeactivateAndActivateCollection()
	{
		$collection_title = ['title'=>($this->titleProvider())[0][0],];

		$collection_id = ($this->billplz->setCollection($collection_title))['id'];

		$deactivate_response = $this->billplz->deactivateCollection($collection_id);
		$activate_response = $this->billplz->activateCollection($collection_id);

		//zero count means we have a correct output
		$this->assertCount(0, $deactivate_response);
		$this->assertCount(0, $activate_response);
	}



	private function setBill()
	{
		$collection_title = ['title'=>($this->titleProvider())[0][0],];

		$data = [
			"collection_id" => ($this->billplz->setCollection($collection_title))['id'], //create new collection
			"description" => substr( md5(rand()), 0, 7),
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
		$response = $this->billplz->verifyAccount($this->readKeyFile()["BANK_ACC"]);

		$this->assertNotNull($response['name']);
	}

}