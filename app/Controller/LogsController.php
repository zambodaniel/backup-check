<?php
App::uses('AppController', 'Controller');
/**
 * Logs Controller
 */
class LogsController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

	public function add(){
		$hostname = $this->request->query('hostname');
		$status = $this->request->query('status');
		$description = $this->request->query('description');
		if (empty($hostname)) {
			throw new NotFoundException('Host not found');
		}
		$host_id = null;
		$host = $this->Log->Host->findByName($hostname);
		if (!$host) {
			$data = array(
				'name' => $hostname
			);
			$this->Log->Host->create();
			$this->Log->Host->save($data);
			$host_id = $this->Log->Host->id;
		} else {
			$host_id = $host['Host']['id'];
		}
		$data = array(
			'host_id' => $host_id,
			'status' => $status,
			'description' => $description
		);
		$this->Log->create();
		$res = $this->Log->save($data);
		$this->autoRender = false;
		echo '';
	}
}
