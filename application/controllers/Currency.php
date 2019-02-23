<?php 
class Currency extends CI_Controller {

	public function view($page = 'list', $date = null)
	{
		if ( ! file_exists(APPPATH.'views/currency/'.$page.'.php'))
		{
				// Whoops, we don't have a page for that!
				show_404();
		}
		
		$this->load->database();
		
		switch($page)
		{
			case 'list':
			

				$data['title'] = "Курс валют"; // Capitalize the first letter
				

				$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				
				
				if($date)
				{
					$data['title'].=" по состоянию на ".rawurldecode($date);
					$curr = $this->db->query('select data from currency_requests where ins_date="'.rawurldecode($date).'"')->result()[0]->data;
				}
				elseif(!$curr = $this->cache->get('curr'))
				{
					$curr = file_get_contents('https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5');
					$query = $this->db->query("insert into currency_requests values (default, "."'".date('Y-m-d H:i:s')."'".", '$curr')");
					$this->cache->save('curr', $curr, 300);
				}
				

				$data['curr'] = json_decode($curr);
				
				break;
			case 'history':
				
				$data['title'] = "История";
				
				$this->load->helper('url');
				$data['base_url'] = base_url('currency/view/list/');
				
				$data['history'] = $this->db->query('select * from currency_requests')->result();
				
				break;
		}

		$this->load->view('templates/header', $data);
		$this->load->view('currency/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
}