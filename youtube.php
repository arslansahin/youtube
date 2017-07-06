<?php

/**
 *
 *  Arslan ŞAHİN
 *  kod2.net
 *  youtube.php
 *  13.Kas.2013
 *
 *  Youtube embed kodundan video'ya ait bilgilerin alınabilmesi için oluşturulmuş bir sınıftır.
 *  $youtube = new youtube('< embed kodu >');
 *  Video Ekran Görüntüsü : $youtube->image_copy('< resmin kopyalanacağı dizin >');
 *  $youtube->image_copy() fonksiyonu,çalıştırıldıktan sonra ekrana kopyalanan resmin ismini basar.
 *  Video Başlığı : $youtube->title();
 *  Video Açıklaması : $youtube->description();
 *
 */
class youtube {

	private $temizle = array('/', 'http', 'https', ':', '.', 'www', 'youtube', 'com', 'youtu.be', 'embed', '\"');
	private $rpc = array('', '', '', '', '', '', '', '', '', '', '');
	private $image_type = array('buyuk' => 0, 'kucuk' => 1);
	const VIDEO_IMAGE_URL = 'http://i.ytimg.com/vi';
	const BOYUT = 'buyuk';
	const VIDEO_PAGE_URL = 'https://www.youtube.com/watch?v=';

    /**
     * 
     * @param type $e
     * @return type
     */
	function __construct($e) {
		return $this->embed = stripslashes($e);
	}

    /**
     * 
     * @return type
     */
	private function url() {
		preg_match('/src="(.*)"/smU', $this->embed, $s);
		$data = str_replace(array('http://', 'https://'), array('//', '//'), $s[1]);
		return $data;
	}

    /**
     * 
     * @return type
     */
	public function videoid() {

		if (strpos($this->embed, 'iframe') !== false) {
			$c = str_replace($this->temizle, $this->rpc, $this->url());
		} else {
			$video_id = str_replace(
				array('http://', 'https://', 'www.youtube.com', 'youtube.com', '.', '/', 'watch?v='), array('', '', '', '', '', '', ''), $this->embed
			);
			$c = $video_id;
		}

		return $c;
	}

    /**
     * 
     * @return type
     */
	private function image_name() {
		return rand(999999, 999999999) . '.jpg';
	}

    /**
     * 
     * @return string
     */
	public function image() {
		$img = self::VIDEO_IMAGE_URL . '/' . $this->videoid() . '/' . $this->image_type[self::BOYUT] . '.jpg';
		return $img;
	}

    /**
     * 
     * @param type $dizin
     * @param type $kucuk_foto_dizin
     * @return type
     */
	public function image_copy($dizin = './',$kucuk_foto_dizin = '') {
		$name = $this->image_name();
		copy($this->image(), $dizin . $name);
        if($kucuk_foto_dizin){
          copy($this->image(), $kucuk_foto_dizin . $name);
        }
		return $name;
	}

    /**
     * 
     * @return type
     */
	private function curl() {
		$c = curl_init();
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_URL, self::VIDEO_PAGE_URL . $this->videoid());
		$contents = curl_exec($c);
		curl_close($c);
		return $contents;
	}

    /**
     * 
     * @return type
     */
	public function video_page_content() {
		return $this->curl();
	}

    /**
     * 
     * @return type
     */
	public function title() {
		preg_match('/property="og:title" content="([^`]*?)"/i', $this->video_page_content(), $title);
		return $title[1];
	}

    /**
     * 
     * @return type
     */
	public function description() {
		preg_match('/property="og:description" content="([^`]*?)"/i', $this->video_page_content(), $description);
		return $description[1];
	}
    
    /**
     * 
     * @return string
     */
	public function embed() {
		if (strpos($this->embed, 'iframe') !== false) {
			$embed_kod = $this->embed;
		} else {
			$video_id = str_replace(
				array('http://', 'https://', 'www.youtube.com', 'youtube.com', '.', '/', 'watch?v='), array('', '', '', '', '', '', ''), $this->embed
			);
			$embed_kod = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe>';
		}
		return $embed_kod;
	}

}
