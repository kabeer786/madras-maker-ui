<?php
class ControllerApiCart extends Controller {
    
    public function registerCustomer() {
    	    $fname=$this->request->get['fname'];
		    $lname=$this->request->get['lname'];
		    $email=$this->request->get['email'];
		    $tele=$this->request->get['tele'];
		    $pass=$this->request->get['pass'];
            $cpass=$this->request->get['cpass'];
            //echo $fname.'==='.$lname.'==='.$email.'==='.$telse.'==='.$pass.'==='.$cpass;
           $data = array();
           $flag = 0;
            
            if($fname == ''){
                 $data['msg']='First Name is mandatory.';
        		 $data['err']='-1';
        		  $flag = 1;
            }
            //print_r($data);
           //die;
            if($lname == ''){
                 $data['msg']='Last Name is mandatory.';
        		 $data['err']='-1';
        		 $flag = 1;
            }
             if($email == ''){
                 $data['msg']='Email is mandatory.';
        		 $data['err']='-1';
        		 $flag = 1;
            }
             if($tele == ''){
                 $data['msg']='Telephone is mandatory.';
        		 $data['err']='-1';
        		 $flag = 1;
            }
            if($pass == ''){
                 $data['msg']='Password is mandatory.';
        		 $data['err']='-1';
        		 $flag = 1;
            }
           /* if($cpass == ''){
                 $data['msg']='Confirm Password is mandatory.';
        		 $data['err']='-1';
        		 $flag = 1;
            }
            
            if($cpass != $pass){
                 $data['msg']='Password and Confirm password does not match.';
        		 $data['err']='-1';
        		 $flag = 1;
            }*/
            
            
            if($flag == '0'){
            
           //  $this->load->model('catalog/product');
              //echo $flag;
             
             $this->load->model('catalog/product');
             $returData = $this->model_catalog_product->getEmail($email);
             
           if ($returData && !$returData['approved']) {
		        $data['msg']='Given Email ID is already added. Try different Email ID.';
            	$data['err']='-1';
	    	}else{
		
            $returData = $this->model_catalog_product->addCust($fname,$lname,$email,$tele,$pass,$cpass);
                if($returData != '1'){
                        $data['msg']='Insert failed.';
            		    $data['err']='-1';
                }
                else{
                    $data['msg']='Success';
            		    $data['err']='1';
                }
	    	}
            }
            
            
            
            $this->response->addHeader('Content-Type: application/json');
          $this->response->addHeader('Access-Control-Allow-Origin: *');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');  
            $this->response->setOutput(json_encode($data));
            
            //die;
        
    }
    
    	public function mobilelogin() {
    	    $email=$this->request->get['email'];
		    $pass=$this->request->get['id'];
		  //  echo $email.$pass;
    	    error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $data = array();
            $this->load->model('account/customer');
         	$customer_info = $this->model_account_customer->getCustomerByEmail($email);

		if ($customer_info && !$customer_info['approved']) {
		  $data['msg']='user is not approved yet';
		   $data['err']='notapproved';
		}
		            		 
             if ($this->customer->login($email,$pass)){
                $this->load->model('account/address');
                $data['address']= $this->model_account_address->getAddress($this->customer->getAddressId());
                $customer_info['password']='';
                 $customer_info['salt']='';
                
                 $data['info']=$customer_info ;
                     $data['success']=true;
                
            }
            else{
                    $data['msg']='invalid email or password';
        		    $data['err']='invalid';
        		      $data['success']=false;
            }   

         		
          $this->response->addHeader('Content-Type: application/json');
          $this->response->addHeader('Access-Control-Allow-Origin: *');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
		$this->response->setOutput(json_encode($data));

    	}
    
    	public function mobileproducts() {
    	    error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $data = array();
            $this->load->model('catalog/product');
            $results = $this->model_catalog_product->getProducts($data);
          $this->response->addHeader('Content-Type: application/json');
          $this->response->addHeader('Access-Control-Allow-Origin: *');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
		$this->response->setOutput(json_encode($results));

    	}
    	
    	public function getFilterProducts() {
    	    error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $data = array();
            $content = trim(file_get_contents("php://input"));
            $data = json_decode($content); 
            $data1 = array();
            foreach ($data->filter_ids as $key => $value) {
              $data1[] = $value->value;
            }
            $list = "'". implode("', '", $data1) ."'";
            //echo $list;
            
            $this->load->model('catalog/product');
            $results = $this->model_catalog_product->getFilteredProd($list);
            $this->response->addHeader('Content-Type: application/json');
            $this->response->addHeader('Access-Control-Allow-Origin: *');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
		    $this->response->setOutput(json_encode($results));
    	}
    	
    	
    	
    	
    	public function getFilters() {
    	    error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $data = array();
            
            
            $this->load->model('catalog/product');
            $results = $this->model_catalog_product->getFilterGrp();
          $this->response->addHeader('Content-Type: application/json');
          $this->response->addHeader('Access-Control-Allow-Origin: *');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
		$this->response->setOutput(json_encode($results));
    	}
    	
    	public function saveRatings() {
    	      //print_r($_POST);die;

     	    //  echo "mine";die;
    	        error_reporting(E_ALL);
                ini_set('display_errors', 1);
              
    	    
    	    	/*$json = '{"customers":[{"custNo":"1","custName":"Rushi","netSales":"30000","dayVisit":"5","monthVisit":"7","yearVisit":"2016","dateVisit":"2016-10-05 10:24:33"}],"status":"true"}'; 
    	    	
    	    	$json = 	'{
                	"rating": [{"name":"staff","value":"1"},{"name":"location","value":"2"},{"name":"facilities","value":"5"},{"name":"value for money","value":"4"}],
                	"user_id": "10",
                	"user_name": "Kabeer",
                	"user_comments": "true",
                	"product_id": "96"
                }';*/
                
          
                
                $content = trim(file_get_contents("php://input"));
                
                 print_r($content);
               
                //       	    echo "inside save called";die;

               // $data = json_decode($content); 
               // echo "\n"; 
                //  echo $data->user_id."\n"; 
                //   echo $data->user_name."\n"; 
                //    echo $data->user_comments."\n"; 
                
                  
                
                /*$someJSON = $data->rating;;//'[{"name":"Jonathan Suh","gender":"male"},{"name":"William Philbin","gender":"male"},{"name":"Allison McKinnery","gender":"female"}]';
                echo "===".$someJSON; 
                foreach ($someJSON as $key => $value) {
                    echo $value->name."==".$value->value;
                }
                  */
                //die;
                
                $this->load->model('catalog/product');
            $results = $this->model_catalog_product->saveRatings($content);
          $this->response->addHeader('Content-Type: application/json');
          $this->response->addHeader('Access-Control-Allow-Origin: *');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
		$this->response->setOutput(json_encode($results));
    	}
    	
    
    	
    	public function getRatingValue() {
    	    error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $str = $_GET['route'];
            $ids=explode("productid=",$str)[1];
            //$id=explode("$$",$ids);

            
            $data = array();
            $this->load->model('catalog/product');
            $results = $this->model_catalog_product->getRatings($ids);
          $this->response->addHeader('Content-Type: application/json');
          $this->response->addHeader('Access-Control-Allow-Origin: *');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
		$this->response->setOutput(json_encode($results));
    	    
    	}
    	
    	
    	public function getProductsLocation() {
    	    
    	    error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $str = $_GET['route'];
            $ids=explode("distance=",$str)[1];
            $id=explode("$$",$ids);
            //echo "Distance:".$id[0];
            //echo "Lat:".$id[1];
            //echo "Long:".$id[2];
     
               //  die;
            
            
            $data = array();
            $this->load->model('catalog/product');
            $results = $this->model_catalog_product->getProductLoc($id);
          $this->response->addHeader('Content-Type: application/json');
          $this->response->addHeader('Access-Control-Allow-Origin: *');
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
		$this->response->setOutput(json_encode($results));
    	}
    	
    	
    		public function mobileproductsbyid() {
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                   // $id=$this->request->post['pid'];
                    $str = $_GET['route'];
                    $ids=explode("pid=",$str)[1];
                  
                
                // echo $ids;die;
                    $data = array();
                    
                    $this->load->model('catalog/product');
    
                    $results = $this->model_catalog_product->getProduct($ids);
                    

                     $results['school_image'] = $this->model_catalog_product->getProductImages($ids);
                    $results['options'] = $this->model_catalog_product->getProductOptions($ids);
                    $results['attribs'] = $this->model_catalog_product->getProductAttributes($ids);
                    //  var_dump($results);die;
               

                    $this->response->addHeader('Content-Type: application/json');
                    $this->response->addHeader('Access-Control-Allow-Origin: *');
                    $this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
                    $this->response->addHeader('Access-Control-Max-Age: 1000');
                    $this->response->setOutput(json_encode($results));
    	}
    	
    	
	public function add() {
		$this->load->language('api/cart');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			if (isset($this->request->post['product'])) {
				$this->cart->clear();

				foreach ($this->request->post['product'] as $product) {
					if (isset($product['option'])) {
						$option = $product['option'];
					} else {
						$option = array();
					}

					$this->cart->add($product['product_id'], $product['quantity'], $option);
				}

				$json['success'] = $this->language->get('text_success');

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
			} elseif (isset($this->request->post['product_id'])) {
				$this->load->model('catalog/product');

				$product_info = $this->model_catalog_product->getProduct($this->request->post['product_id']);

				if ($product_info) {
					if (isset($this->request->post['quantity'])) {
						$quantity = $this->request->post['quantity'];
					} else {
						$quantity = 1;
					}

					if (isset($this->request->post['option'])) {
						$option = array_filter($this->request->post['option']);
					} else {
						$option = array();
					}

					$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

					foreach ($product_options as $product_option) {
						if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
							$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
						}
					}

					if (!isset($json['error']['option'])) {
						$this->cart->add($this->request->post['product_id'], $quantity, $option);

						$json['success'] = $this->language->get('text_success');

						unset($this->session->data['shipping_method']);
						unset($this->session->data['shipping_methods']);
						unset($this->session->data['payment_method']);
						unset($this->session->data['payment_methods']);
					}
				} else {
					$json['error']['store'] = $this->language->get('error_store');
				}
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function edit() {
		$this->load->language('api/cart');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$this->cart->update($this->request->post['key'], $this->request->post['quantity']);

			$json['success'] = $this->language->get('text_success');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove() {
		$this->load->language('api/cart');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			// Remove
			if (isset($this->request->post['key'])) {
				$this->cart->remove($this->request->post['key']);

				unset($this->session->data['vouchers'][$this->request->post['key']]);

				$json['success'] = $this->language->get('text_success');

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
				unset($this->session->data['reward']);
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function products() {
		$this->load->language('api/cart');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			// Stock
			if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$json['error']['stock'] = $this->language->get('error_stock');
			}

			// Products
			$json['products'] = array();

			$products = $this->cart->getProducts();

			foreach ($products as $product) {
				$product_total = 0;

				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$json['error']['minimum'][] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}

				$option_data = array();

				foreach ($product['option'] as $option) {
					$option_data[] = array(
						'product_option_id'       => $option['product_option_id'],
						'product_option_value_id' => $option['product_option_value_id'],
						'name'                    => $option['name'],
						'value'                   => $option['value'],
						'type'                    => $option['type']
					);
				}

				$json['products'][] = array(
					'cart_id'    => $product['cart_id'],
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'quantity'   => $product['quantity'],
					'stock'      => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					'shipping'   => $product['shipping'],
					'price'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']),
					'total'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $this->session->data['currency']),
					'reward'     => $product['reward']
				);
			}

			// Voucher
			$json['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$json['vouchers'][] = array(
						'code'             => $voucher['code'],
						'description'      => $voucher['description'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],
						'price'            => $this->currency->format($voucher['amount'], $this->session->data['currency']),			
						'amount'           => $voucher['amount']
					);
				}
			}

			// Totals
			$this->load->model('extension/extension');

			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

			// Because __call can not keep var references so we put them into an array. 
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);
			
			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('extension/total/' . $result['code']);
					
					// We have to put the totals in an array so that they pass by reference.
					$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
				}
			}

			$sort_order = array();

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $totals);

			$json['totals'] = array();

			foreach ($totals as $total) {
				$json['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
				);
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
