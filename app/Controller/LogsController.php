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
		$this->request->allowMethod('get');
		$apiKey = Configure::read('ApiKey');
		$hostname = $this->request->query('hostname');
		$status = $this->request->query('status');
		$description = $this->request->query('description');
		$query_key = $this->request->query('key');
		if ($query_key !== $apiKey) {
			throw new InternalErrorException('Invalid key');
		}
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
		if (!$res) {
			throw new InternalErrorException('Error saving log entry');
		}
		$this->autoRender = false;
		echo 'OK';
	}
}
