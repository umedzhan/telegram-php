<?php

class Telegram {
	public $token;
	
	public function __construct($token) {
		$this->token = $token;
	}
	
	public function bot($method, $data = []) {
		$token = $this->token;
		$url = "https://api.telegram.org/bot$token/$method";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($ch);
		curl_close($ch);
		return json_decode($response, true);
	}
	
	public function getUpdate() {
		return json_decode(file_get_contents('php://input'), true);
	}
	
	public function Message() {
		if (isset($this->getUpdate()['message'])) {
			return 'message';
		} else if (isset($this->getUpdate()['callback_query'])) {
			return 'callback_query';
		} else {
			return NULL;
		}
	}
	
	public function ChatID() {
		$update = $this->getUpdate();
		return $update[$this->Message()]['chat']['id'];
	}
	
	public function FirstName() {
		return $this->getUpdate()[$this->Message()]['chat']['first_name'];
	}
	
	public function LastName() {
		return $this->getUpdate()[$this->Message()]['chat']['last_name'] ?? NULL;
	}
	
	
	
	public function Text() {
		$update = $this->getUpdate();
		return isset($update[$this->Message()]['text']) ? $update['message']['text'] : '';
	}
	
	public function sendMessage($chat_id, $text) {
		return $this->bot('sendMessage', [
			'chat_id' => $chat_id,
			'text' => $text
		]);
	}
}
