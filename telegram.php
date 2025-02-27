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

	public function CallbackData() {
		$update = $this->getUpdate();
		return isset($update[$this->Message()]['data']) ? $update['callback_query']['data'] : '';
	}

	public function CallbackID() {
		$update = $this->getUpdate();
		return isset($update[$this->Message()]['message_id']) ? $update['callback_query']['message']['message_id'] : '';
	}

	public function Contact() {
		$update = $this->getUpdate();
		return isset($update[$this->Message()]['contact']) ? $update['message']['contact'] : '';
	}

	public function Location() {
		$update = $this->getUpdate();
		return isset($update[$this->Message()]['location']) ? $update['message']['location'] : '';
	}
	
	public function sendMessage($chat_id, $text, $parse_mode = '') {
		return $this->bot('sendMessage', [
			'chat_id' => $chat_id,
			'text' => $text,
			'parse_mode' => $parse_mode
		]);
	}

	public function sendPhoto($chat_id, $photo, $caption = '') {
		return $this->bot('sendPhoto', [
			'chat_id' => $chat_id,
			'photo' => $photo,
			'caption' => $caption
		]);
	}

	public function sendVideo($chat_id, $video, $caption = '') {
		return $this->bot('sendVideo', [
			'chat_id' => $chat_id,
			'video' => $video,
			'caption' => $caption
		]);
	}

	public function sendAudio($chat_id, $audio, $caption = '') {
		return $this->bot('sendAudio', [
			'chat_id' => $chat_id,
			'audio' => $audio,
			'caption' => $caption
		]);
	}

	public function sendDocument($chat_id, $document, $caption = '') {
		return $this->bot('sendDocument', [
			'chat_id' => $chat_id,
			'document' => $document,
			'caption' => $caption
		]);
	}

	public function sendSticker($chat_id, $sticker) {
		return $this->bot('sendSticker', [
			'chat_id' => $chat_id,
			'sticker' => $sticker
		]);
	}

	public function sendAnimation($chat_id, $animation, $caption = '') {
		return $this->bot('sendAnimation', [
			'chat_id' => $chat_id,
			'animation' => $animation,
			'caption' => $caption
		]);
	}

	public function sendVoice($chat_id, $voice) {
		return $this->bot('sendVoice', [
			'chat_id' => $chat_id,
			'voice' => $voice
		]);
	}

	public function sendLocation($chat_id, $latitude, $longitude) {
		return $this->bot('sendLocation', [
			'chat_id' => $chat_id,
			'latitude' => $latitude,
			'longitude' => $longitude
		]);
	}

	public function sendChatAction($chat_id, $action) {
		return $this->bot('sendChatAction', [
			'chat_id' => $chat_id,
			'action' => $action
		]);
	}
}
