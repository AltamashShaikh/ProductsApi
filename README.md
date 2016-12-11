## Checkout the Following Repo
## Requiremnets
	Mysql db (get the mysql file in app/db folder)
	Redis
	Apache mod rewrite should be enabled


## Make a virtual host which points till the app/webroot directory
	eg DocumentRoot "/var/wdocumenww/html/ProductsApi/app/webroot"

## for simplicity assume the endpoint is http://localhost.productsapi/

## To upload the image make a request to following endpoint
	http://localhost.productsapi/Images/upload

  The field name of the image should be "image".
	
	On a successful request following output will be return {"status":"Success","message":"Image stored in redis successfully","image_id":"product_images_1481495072_2c012"}

## To store the products info you need to send the image_id received in response of above requuest make a post request to following url and send the data  as json mentioned below

		http://localhost.productsapi/Products/add/
		
		{
		"image_id":"product_images_1481495072_2c012",
		"name":"Test",
		"price":"400"
		}

	Response
	
	{"status":"Success","message":"Products Inserted Successfully","id":"3"}


## To get the products info hit the following url as a GET request

	http://localhost.productsapi/Products/

	Response

	{"data":[{"Product":{"product_id":"1","product_name":"testabc","image":"http:\/\/localhost.productsapi\/img\/product_images_1481479749_2c012_actual_image.jpeg","image_256":"http:\/\/localhost.productsapi\/img\/product_images_1481479749_2c012_256_pixel_image.jpeg","image_512":"http:\/\/localhost.productsapi\/img\/product_images_1481479749_2c012_512_pixel_image.jpeg","price":"400","creation_date":"2016-12-12","updation_date":"2016-12-12 03:17:27","is_deleted":"0"}},{"Product":{"product_id":"3","product_name":"Test","image":"http:\/\/localhost.productsapi\/img\/product_images_1481495072_2c012_actual_image.jpeg","image_256":"http:\/\/localhost.productsapi\/img\/product_images_1481495072_2c012_256_pixel_image.jpeg","image_512":"http:\/\/localhost.productsapi\/img\/product_images_1481495072_2c012_512_pixel_image.jpeg","price":"400","creation_date":"2016-12-12","updation_date":"2016-12-12 04:07:14","is_deleted":"0"}}],"status":"Success"}
	
	
## Additional Apis

	To update product details
	
	Request: Make the following post Request
	
	http://localhost.productsapi/Products/update/1
	
	{
		"image_id":"product_images_1481495072_2c012",
		"name":"Test123",
		"price":"4000"
		}
		
	Response

	{"status":"Success","message":"Product Details Updated Successfully"}

	To get product info of a particular id
	
	Request: Make a get Request to the following URL
	
	http://localhost.productsapi/Products/1

	Response

	{"data":[{"Product":{"product_id":"1","product_name":"testabc","image":"http:\/\/localhost.productsapi\/img\/product_images_1481479749_2c012_actual_image.jpeg","image_256":"http:\/\/localhost.productsapi\/img\/product_images_1481479749_2c012_256_pixel_image.jpeg","image_512":"http:\/\/localhost.productsapi\/img\/product_images_1481479749_2c012_512_pixel_image.jpeg","price":"400","creation_date":"2016-12-12","updation_date":"2016-12-12 03:17:27","is_deleted":"0"}}],"status":"Success"}

	To delete a product

	Request: Make a post Request to the folllowing url

	http://localhost.productsapi/Products/delete/1

	Response

	{"status":"Success","message":"Products Deleted Successfully"}



	
		
	


