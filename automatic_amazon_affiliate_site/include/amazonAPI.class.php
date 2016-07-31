<?php

class amazonAPI
{
	private $public_key;
    private $private_key;
    private $associate_tag;
	public $min_discount; 
	public $region;
 
    public function __construct($a, $b, $c, $d, $e)
	{
		$this->public_key = $a;
		$this->private_key = $b;
		$this->associate_tag = $c;
		$this->min_discount = $d; 
		$this->region = $e;
	}
 
    private function verifyXmlResponse($response)
    {
		if (isset($response->Items->Item->ItemAttributes->Title))
		{
			return ($response);
		}
		else
		{
			return false;
		}
    }
 
    private function queryAmazon($parameters)
    {
        return $this->awsSignedRequest($parameters);
    }
 
    public function searchProducts($search, $category, $page=1)
    {
		$arr = array();
	
		$parameters = array("Operation"     	=> "ItemSearch",
							"Keywords"      	=> $search,
							"SearchIndex"   	=> $category,
//							"BrowseNode"		=> "2956501011",
							"Condition"			=> "New",
							"MerchantId"		=> "Amazon",
							"MinPercentageOff" 	=> ($min_discount*100),
							"ItemPage"			=> $page,
							"ResponseGroup" 	=> "ItemAttributes,OfferFull,Images");

 
        $xml_response = $this->queryAmazon($parameters);
 
        $raw = $this->verifyXmlResponse($xml_response);
		
		if (!is_null($raw->Items->Item))
		{
			foreach ($raw->Items->Item as $p)
			{
				$price = (double)$p->Offers->Offer->OfferListing->Price->Amount/100;
				$reg_price = (double)$p->ItemAttributes->ListPrice->Amount/100;
				
				if ($this->itemFilter((string)$p->ItemAttributes->Title))
				{
					if ($price != 0 && $reg_price != 0 && $price/$reg_price <= $this->min_discount)
					{
						$arr[] = array(
							"vendor" => "amazon.".$this->region,
							"upc" => (string)$p->ItemAttributes->UPC,
							"mfg_part_no" => (string)$p->ItemAttributes->Model,
							"name" => (string)$p->ItemAttributes->Title,
							"price" => $price,
							"reg_price" => $reg_price,
							"category" => (string)$p->ItemAttributes->ProductGroup,
							"description" => "",
							"images" => array((string)$p->LargeImage->URL),
							"link" => (string)$p->DetailPageURL
						);
					}
				}
			}
		}
		
		if ($page < 10 && $page < $raw->Items->TotalPages) return array_merge($arr, $this->searchProducts($search, $category, $page+1));
		else return $arr;
		return $raw;
    }
	
	private function itemFilter($string)
	{
		$disallowed = array(
			"cable", "Cable",
			"cord", "Cord",
			"adapter", "Adapter",
			"case", "Case",
			"bag", "Bag",
			"memory card", "Memory Card",
			"mount", "Mount",
			"flash drive", "Flash Drive",
			"laptop battery", "Laptop Battery"
		);
		
		foreach ($disallowed as $d)
		{
			if (strpos($string, $d) !== false)
				return false;
		}
		
		return true;
	}
 
	private function awsSignedRequest($params)
	{
		if($region == 'jp'){
			$host = "ecs.amazonaws.".$this->region;
		}else{
			$host = "webservices.amazon.".$this->region;
		}

		$method = "GET";
		$uri = "/onca/xml";

		$params["Service"]          = "AWSECommerceService";
		$params["AWSAccessKeyId"]   = $this->public_key;
		$params["AssociateTag"]     = $this->associate_tag;
		$params["Timestamp"]        = gmdate("Y-m-d\TH:i:s\Z");
		$params["Version"]          = "2011-08-01";
		
		ksort($params);
	 
		$canonicalized_query = array();
	 
		foreach ($params as $param=>$value)
		{
			$param = str_replace("%7E", "~", rawurlencode($param));
			$value = str_replace("%7E", "~", rawurlencode($value));
			$canonicalized_query[] = $param."=".$value;
		}
	 
		$canonicalized_query = implode("&", $canonicalized_query);
	 
		$string_to_sign = $method."\n".$host."\n".$uri."\n".
								$canonicalized_query;
	 
		$signature = base64_encode(hash_hmac("sha256", 
									  $string_to_sign, $this->private_key, true));
	 
		$signature = str_replace("%7E", "~", rawurlencode($signature));
	 
		$request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;
	 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	 
		$xml_response = curl_exec($ch);
	 
		if ($xml_response === false)
		{
			return false;
		}
		else
		{
			$parsed_xml = @simplexml_load_string($xml_response);
			return ($parsed_xml);
		}
	}
}

?>