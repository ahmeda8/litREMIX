<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 public function __construct()
	 {
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('text');
	 }
	 
	public function index()
	{
		//var_dump($res);
		$data['type']= "search";
		$this->load->view('search_view',$data);
	}
	
	public function result($action)
	{
		
		if($action == "featured")
			$book = "The Oddesey";
		else
			$book = $_POST['book'];
		$data['type']= "result";
		$data['youtube'] = $this->get_youtube_array($book);
		$this->load->database();
		$sql = "select * from songs join books on songs.id_book = books.id_book where book_name like '%".$book."%' ";
		$res = $this->db->query($sql);
		$data['book_info'] = $res->row();
		$data['result_src'] = $res;
		
		//load penguin
		$data['articles']=$this->get_penguin($book);
		$this->load->view('search_view',$data);
	}
	
	public function upload($file)
	{
		$this->load->database();
		//print_r($_POST);
		//exit();
		if($file=="youtube")
		{
			$this->db->insert('user_upload',array('id_book'=>$_POST['book'],'youtube'=>$_POST['youtube']));
			$this->login();
		}
		else
		{
			$sql = "select * from books";
			$res = $this->db->query($sql);
			$data['result_src'] = $res;
			$data['type']="upload";
			$this->load->view('search_view',$data);
		}
	}
	
	public function login()
	{
		$data['type']="login";
		$data['youtube'] = $this->get_youtube_array("",false);
		$this->load->view('search_view',$data);
	}
	
	private function get_youtube_array($book,$single=true)
	{
		$this->load->database();
		if($single)
			$sql = "select * from user_upload join books on user_upload.id_book = books.id_book where book_name like '%".$book."%' order by book_name asc ";
		else
			$sql = "select * from user_upload join books on user_upload.id_book = books.id_book order by book_name asc ";
		$res = $this->db->query($sql);
		$return_arr = array();
		foreach($res->result() as $row)
		{
			$dat = array();
			$dat['book'] = $row->book_name;
		// create a new cURL resource
			$ch = curl_init();

			// set URL and other appropriate options
			$video = "https://gdata.youtube.com/feeds/api/videos/".$row->youtube."?v=2&alt=json";
			$playlist = "http://gdata.youtube.com/feeds/mobile/playlists/PL-LHKuA3lI55yA4pP6IWl5KiHBQLxBMS0?alt=json";
			curl_setopt($ch, CURLOPT_URL, $video);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			

			// grab URL and pass it to the browser
			$json = curl_exec($ch);

			// close cURL resource, and free up system resources
			curl_close($ch);
			$dat['youtube'] = json_decode($json,true);
			//print_r($dat['youtube']);exit();
			$return_arr[] = $dat;
		}
		return $return_arr;
	}
	
	private function get_penguin($book)
	{
		$api_key = "fb78b5c5587307724cd3715446125cf3";
		$articles = array();
		$list_books ="https://api.pearson.com/penguin/classics/v1/books?apikey=$api_key&limit=2&title=".urlencode($book);
		
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $list_books);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		

		// grab URL and pass it to the browser
		$json = curl_exec($ch);

		// close cURL resource, and free up system resources
		curl_close($ch);
		$data = json_decode($json,true);
		if($data['count']>0)
		{
			$ch = curl_init();

			// set URL and other appropriate options
			curl_setopt($ch, CURLOPT_URL, $data['books'][0]['url']);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			

			// grab URL and pass it to the browser
			$books = json_decode(curl_exec($ch),true);

			// close cURL resource, and free up system resources
			curl_close($ch);
		
		
			//print_r($books);
			
			for($i=0;$i<3;$i++)
			{
				$ch = curl_init();

				// set URL and other appropriate options
				curl_setopt($ch, CURLOPT_URL, $books['book']['articles'][$i]['url']."&content-fmt=text");
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				

				// grab URL and pass it to the browser
				$articles[] = json_decode(curl_exec($ch),true);

				// close cURL resource, and free up system resources
				curl_close($ch);
				
			}
		}
		//print_r($articles);
		//exit();
		return $articles;
	}
	
	public function lyrics($artist,$track)
	{
		$artist = str_replace(" ","_",$artist);
		$track = str_replace(" ","_",$track);
		$apikey="e6b83991a3cac0f788f594c5af76e2fea6b5316c";
		$url ="http://lyrics.wikia.com/api.php?func=getSong&artist=".$artist."&song=".$track."&fmt=text";
		
		$ch = curl_init();

				// set URL and other appropriate options
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				

				// grab URL and pass it to the browser
				$data['lyrics'] =curl_exec($ch);

				// close cURL resource, and free up system resources
				curl_close($ch);
				//print_r($lyrics);
				//exit();
				$data['type']="lyrics";
				$this->load->view('search_view',$data);
	}
	
	public function questions($id)
	{
		$this->load->database();
		$sql = "select * from questions join songs on questions.id_song= songs.id_song where songs.id_song = ?";
		$data['result_src'] = $this->db->query($sql,array($id));
		
		$data['type'] = "quiz";
		$this->load->view('search_view',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */