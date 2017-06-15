<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Test extends CI_Controller{
		function __construct(){
			parent::__construct();
			date_default_timezone_set('Asia/Jakarta');
			
			// Load facebook library
    		$this->load->library('facebook');
		}
		
		public function index(){
		    var_dump('test');
		    // require_once('./assets/codebird-php-develop/src/codebird.php');
            				 
            // \Codebird\Codebird::setConsumerKey("VqFzLQJRfIxX0Mbt9HO4VxeNX", "ko5FfipdHY6VN1MJMSMBcvh3MoW2YmbaHpRwJh7hafYTO9z1Vp");
            // $cb = \Codebird\Codebird::getInstance();
            // $cb->setToken("862295903951929344-nYPh4FWe0myoVdNEF9qkxFtHcxwN7n5", "jd1SjHaqBxByUxzFk8lY7keElT6dvJXSjbl97aDGVK27l");
             
            // $params_twit = array(
              // 'status' => "Badan Intelejen Inggris Lakukan Penyelidikan Internal Pasca Bom Manchester http://suarakaryanews.com/index.php/berita/artikel/Badan+Intelejen+Inggris+Lakukan+Penyelidikan+Internal+Pasca+Bom+Manchester",
              // 'media[]' => "http://suarakaryanews.com/uploads/post/original/25-05-2017-manchester-bombing-4-590.jpg"
            // );
            // $cb->statuses_updateWithMedia($params_twit);
            
            // $userAccessToken = 'EAAEPgdYZAvawBAMokTvcoGwREFL42amADc0vCHnU1EhfuYXhAxyaOeUJXfXOH0TVgJn83ghi88EzaCYN5HcW4vQCLLRgf80yL2FQ98iKQsuCaAYaUShNRqnKtqC6RqNTrjprlt24EgQGbQQXZAtyyqaAEsOpUJgCu9athKegZDZD';
            // $param = [
            	// 'message'       => 'Badan Intelejen Inggris Lakukan Penyelidikan Internal Pasca Bom Manchester',
            	// 'name'          => 'Suara Karya News',
            	// 'link'          => 'http://suarakaryanews.com/index.php/berita/artikel/Badan+Intelejen+Inggris+Lakukan+Penyelidikan+Internal+Pasca+Bom+Manchester',
            	// 'description'   => 'Pemerintah Inggris berupaya menanggapi dengan serius insiden bom bunuh diri di konser Ariana Grande pada Senin 22 Mei 2017 malam waktu setempat. Badan Intelijen Inggris, MI5, menggelar penyilidikan internal mengapa bisa kecolongan atas informasi gerak-gerik Salman Abedi, pelaku pengeboman di Manchester Arena tersebut. 
            						// Menteri Dalam Negeri Inggris Amber Rudd menyambut baik penyelidikan tersebut. Perempuan berusia 53 tahun itu menganggap investigasi internal MI5 sebagai langkah tepat pertama yang diambil badan yang tengah disorot karena dinilai gagal merespons informasi terkait Salman Abedi.',
            // ];
            // $this->facebook->share_fb($param, $userAccessToken);
		}
		
	}
/*end of file Test.php*/
/*Location:.application/controllers/back/Test.php*/	