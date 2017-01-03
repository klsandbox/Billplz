# BillPlz Client For Laravel

![Build Status](https://img.shields.io/circleci/project/github/hamzahjamad/billplz.svg?style=flat-square)

This client is a simple Billplz client that can be used with Laravel 5. You may check their [api](https://www.billplz.com/api) for full documentation.

## How To Use
After installing via composer, simply use it by creating a new object and put the Api key as it argument.

`$billplz = new Hamzahjamad\BillPlz\BillPlz("Token_here");`

To use the Sandbox Mode api, just pass `false` as a second argument.

`$billplz = new Hamzahjamad\BillPlz\BillPlz("Token_here" , false);`

##### Create a new collection.
`$billplz = new Hamzahjamad\BillPlz\BillPlz("Token_here");`
`$billplz->setCollection(['title'=>'Ahmad Shop']);`

##### Create a new bill.
`$billplz = new Hamzahjamad\BillPlz\BillPlz("Token_here");`

```
$data = [
        "collection_id" => "some_collection_id",
        "description" => "some_description",
        "name" => "test",
        "email" => "test@example.com",
        "amount" => 300,
        "callback_url" => "https://test.com/test",
        ];        
```

`$billplz->setBill($data);`


### List of available method
#### Collection
* `setCollection(array $data)`
* `setOpenCollection(array $data)`
* `deactivateCollection($collection_id)`
* `activateCollection($collection_id)`

#### Bill
* `setBill(array $data)`
* `getBill($bill_id)`
* `deleteBill($bill_id)`

#### Bank Account
* `verifyAccount($bank_account)`


## Run Test File
To run the test, create a new `secret-env-plain` file. In this file, put this two line,

```
TOKEN=PUT_TOKEN_HERE
BANK_ACC=PUT_BANK_ACCOUNT_HERE
```


replace the PUT_TOKEN_HERE and PUT_BANK_ACCOUNT_HERE text with the token and bank account you filled on the staging server. The test will run using the staging server api.

## Security Vulnerabilities

If you discover a security vulnerability within this BillPlz client, please send an e-mail to Hamzah Jamad at hamzahjamad@gmail.com. 

## License

This client are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
