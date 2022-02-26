<?php 

include_once 'db.php';


function Noon_Offer_Content($zsku='',$offer_code=null)
{global $context,$dbc;
 
  $col = ""; $VALUE = ""; // keep empty


  $context = stream_context_create(
    array(
        "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36",
            "ignore_errors" => true // ignore 404 status when product is out of stock
        )
    )
  );
  

  
  
if (is_null($offer_code)) {
  # code...
  $url = "https://www.noon.com/saudi-en/".$zsku."/p/";
  $url_ar = "https://www.noon.com/saudi-ar/".$zsku."/p/";
}else{
  $url = "https://www.noon.com/saudi-en/".$zsku."/p/?o=.$offer_code.";
  $url_ar = "https://www.noon.com/saudi-ar/".$zsku."/p/?o=.$offer_code.";
}
  
      
  function get_http_response_code($url) { global $context;  $headers = get_headers($url, false, $context);  return substr($headers[0], 9, 3);}

  function get_http_response_code_ar($url_ar) { global $context; $headers = get_headers($url_ar, false, $context);  return substr($headers[0], 9, 3);}


  $result = file_get_contents($url, false, $context);
  $result_ar = file_get_contents($url_ar, false, $context); // ar


  if(get_http_response_code($url) == "200" && get_http_response_code_ar($url_ar) == "200" ){
  
    preg_match('/<script id="__NEXT_DATA__" type="application\/json">(.+)<\/script><script type/i', $result, $nis);
    preg_match('/<script id="__NEXT_DATA__" type="application\/json">(.+)<\/script><script type/i', $result_ar, $nis_ar); // ar

    $offer = true;

  
  }elseif (get_http_response_code($url) == "404" && get_http_response_code_ar($url_ar) == "404") {
    # code...
    preg_match('/<script id="__NEXT_DATA__" type="application\/json">(.+)<\/script>/i', $result, $nis);
    preg_match('/<script id="__NEXT_DATA__" type="application\/json">(.+)<\/script>/i', $result_ar, $nis_ar); // ar
    $offer = false;

  }
  else{echo "somthing wrong!";die;}
    



    $nis[1] = isset($nis[1]) ? $nis[1] : null;
    $nis_ar[1] = isset($nis_ar[1]) ? $nis_ar[1] : null; // ar
     $data = $nis[1];
     $data_ar = $nis_ar[1]; //ar

    
    $string = $data; 
    $string_ar = $data_ar; //ar

    $string = str_replace('\n', '', $string); $string = str_replace("'", "", $string); $string = str_replace("’", "", $string);
    $string_ar = str_replace('\n', '', $string_ar);  $string_ar = str_replace("'", "", $string_ar);  $string_ar = str_replace("’", "", $string_ar); //ar

  //file_put_contents('json.json', $string);        /// for local testing
  
   
  $json = json_decode($string);
  $json_ar = json_decode($string_ar);
  
if (empty($json->props->pageProps->props->catalog->product)) { 
  echo"404";
  die; // die when product page 404
}
  
   //echo"<h1>Product :</h1>";
  $sku = $json->props->pageProps->props->catalog->product->sku; // SKU
  $col .= "sku"; $VALUE .= "'$sku'";
 
   $category_code = $json->props->pageProps->props->catalog->product->category_code; // category_code
   $col .= ", category_code"; $VALUE .= ", '$category_code'";
 
   $product_title = $json->props->pageProps->props->catalog->product->product_title; // Title
   $col .= ", product_title"; $VALUE .= ",'$product_title'";
    
   $product_title_ar = $json_ar->props->pageProps->props->catalog->product->product_title; //Title ar
   $col .= ", product_title_ar"; $VALUE .= ",'$product_title_ar'";    
  
   $brand = $json->props->pageProps->props->catalog->product->brand; // Brand
   $col .= ", brand"; $VALUE .= ",'$brand'";
    
   $brand_ar = $json_ar->props->pageProps->props->catalog->product->brand; // Brand ar
   $col .= ", brand_ar"; $VALUE .= ",'$brand_ar'";
   
   $zsku = $json->props->pageProps->props->catalog->product->variants[0]->sku; // zsku
   $col .= ", zsku"; $VALUE .= ", '$zsku'";
 
   $long_description = $json->props->pageProps->props->catalog->product->long_description; // long_description
   $col .= ", long_description"; $VALUE .= ", '$long_description'";
    
   $long_description_ar = $json_ar->props->pageProps->props->catalog->product->long_description; // long_description ar
   $col .= ", long_description_ar";  $VALUE .= ",'$long_description_ar'";
    
   $feature_bullets = $json->props->pageProps->props->catalog->product->feature_bullets; // feature_bullets  output = json
   $feature_bullets = json_encode($feature_bullets, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
   $col .= ", feature_bullets"; $VALUE .= ", '$feature_bullets'";

    
   $feature_bullets_ar = $json_ar->props->pageProps->props->catalog->product->feature_bullets; // feature_bullets ar  output = json
   $feature_bullets_ar = json_encode($feature_bullets_ar, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
   $col .= ", feature_bullets_ar"; $VALUE .= ",'$feature_bullets_ar'";
   
        
   
   
   if ($offer != false) {
     # code...
  

   $offers = $json->props->pageProps->props->catalog->product->variants[0]->offers; // offers
   
   $offer_code = $offers[0]->offer_code; // offer_code
   $col .= ", offer_code"; $VALUE .= ", '$offer_code'";
    
   $price = $offers[0]->price; // original price 
   $col .= ", price"; $VALUE .= ", '$price'";
      
   $sale_price = $offers[0]->sale_price; //sale_price live on noon 
   $col .= ", sale_price"; $VALUE .= ", '$sale_price'";
      
   $url = $offers[0]->url; // url
   $col .= ", url"; $VALUE .= ", '$url'";
        
   $id_product_fulltype = $offers[0]->id_product_fulltype; // id_product_fulltype
   $col .= ", id_product_fulltype"; $VALUE .= ", '$id_product_fulltype'";
     
   $authentic_seller = $offers[0]->authentic_seller; // authentic_seller
   $col .= ", authentic_seller"; $VALUE .= ", '$authentic_seller'";
  
   $stock = $offers[0]->stock; // stock
   $col .= ", stock"; $VALUE .= ", '$stock'";
     
   $offer_stock_net = $offers[0]->offer_stock_net; // offer_stock_net
   $col .= ", offer_stock_net"; $VALUE .= ", '$offer_stock_net'";
       
   $is_fbn = $offers[0]->is_fbn; // is_fbn
   $col .= ", is_fbn"; $VALUE .= ", '$is_fbn'";
      
   $is_bestseller = $offers[0]->is_bestseller; // is_bestseller
   $col .= ", is_bestseller"; $VALUE .= ", '$is_bestseller'";
    
   $store_name = $offers[0]->store_name; // store_name
   $col .= ", store_name"; $VALUE .= ", '$store_name'";
  
   $store_code = $offers[0]->store_code; // store_code
   $col .= ", store_code"; $VALUE .= ", '$store_code'";
    
   $partner_code = $offers[0]->partner_code; // partner_code
   $col .= ", partner_code"; $VALUE .= ", '$partner_code'";
    
   $note = $offers[0]->note; // note
   $col .= ", note"; $VALUE .= ", '$note'";
    
  }
   
   
 
   
   
   
   
   
   
   $specifications = $json->props->pageProps->props->catalog->product->specifications;
   $specifications_ar = $json_ar->props->pageProps->props->catalog->product->specifications;

   $count_specifications = count($specifications);
   //echo"<h1>specifications :</h1>";
    
   for ($i=0; $i < $count_specifications ; $i++) { 
     # code...
     
     if ($specifications[$i]->code == 'colour_name') {$colour_name = $specifications[$i]->value;   $col .= ", colour_name"; $VALUE .= ", '$colour_name'";} 
     if ($specifications_ar[$i]->code == 'colour_name') {$colour_name_ar = $specifications_ar[$i]->value;   $col .= ", colour_name_ar"; $VALUE .= ",'$colour_name_ar'";} //ar
   
     if ($specifications[$i]->code == 'size') {$size = $specifications[$i]->value;   $col .= ", size";  $VALUE .= ", '$size'";} 
     if ($specifications_ar[$i]->code == 'size') {$size_ar = $specifications_ar[$i]->value;   $col .= ", size_ar"; $VALUE .= ",'$size_ar'";} //ar
 
     if ($specifications[$i]->code == 'whats_in_the_box') {$whats_in_the_box = $specifications[$i]->value;  $col .= ", whats_in_the_box"; $VALUE .= ", '$whats_in_the_box'";} 
     if ($specifications_ar[$i]->code == 'whats_in_the_box') {$whats_in_the_box_ar = $specifications_ar[$i]->value;   $col .= ", whats_in_the_box_ar"; $VALUE .= ",'$whats_in_the_box_ar'";} //ar
     
     if ($specifications[$i]->code == 'model_number') {$model_number = $specifications[$i]->value;   $col .= ", model_number"; $VALUE .= ", '$model_number'";} 
    // if ($specifications_ar[$i]->code == 'model_number') { echo"model_number :";echo $model_number_ar = $specifications_ar[$i]->value;  } //ar

     if ($specifications[$i]->code == 'model_name') {$model_name = $specifications[$i]->value;    $col .= ", model_name"; $VALUE .= ", '$model_name'";} 
      //if ($specifications_ar[$i]->code == 'model_name') {   echo"model_name :"; echo $model_name_ar = $specifications_ar[$i]->value;  } //ar

     if ($specifications[$i]->code == 'number_of_pieces') {$number_of_pieces = $specifications[$i]->value;     $col .= ", number_of_pieces";  $VALUE .= ", '$number_of_pieces'";} 
    // if ($specifications_ar[$i]->code == 'number_of_pieces') {   echo"number_of_pieces :"; echo $number_of_pieces_ar = $specifications_ar[$i]->value;  } //ar

     if ($specifications[$i]->code == 'country_of_origin') {$country_of_origin = $specifications[$i]->value;    $col .= ", country_of_origin"; $VALUE .= ", '$country_of_origin'";} 
     if ($specifications_ar[$i]->code == 'country_of_origin') {$country_of_origin_ar = $specifications_ar[$i]->value;    $col .= ", country_of_origin_ar";   $VALUE .= ",'$country_of_origin_ar'";   } //ar
   
   }


 //echo   var_dump($image_keys = $json->props->pageProps->props->catalog->product->image_keys);
 //  $count_image_keys = count($image_keys);
 //  for ($i=0; $i < $count_image_keys ; $i++) { 
 //    echo"https://z.nooncdn.com/products/";
 //    echo $image_keys[$i];
//echo".jpg";
//echo "<br>";

 //  }
   
  

 $sql = "INSERT INTO noon_offer ($col) VALUES ($VALUE)";
    $sql .="";
    $query = mysqli_query($dbc, $sql);
    



}

Noon_Offer_Content('N23042943A'); /// NIS or ZSKU (required) , offer_code (optional)
