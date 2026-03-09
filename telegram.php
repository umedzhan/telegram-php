<?php

class Telegram {
	private $token;
    public $update;
	
	public function __construct($token) {
		$this->token = $token;
        $this->update = json_decode(file_get_contents('php://input'), true);
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

    public function token() {
        return $this->token;
    }

    public function ChatID() {
        if ($this->isMessage()) {
            return $this->update['message']['from']['id'];
        } else if ($this->isQuery()) {
            return $this->update['callback_query']['from']['id'];
        } else if ($this->isBusinessMessage()) {
            return $this->update['business_message']['chat']['id'];
        }
    }

    public function messageID() {
        if ($this->isBusinessMessage()) {
            return $this->update['business_message']['message_id'];
        }
    }

    public function BusinessConnectionID() {
        if ($this->isBusinessMessage()) {
            return $this->update['business_message']['business_connection_id'];
        }
    }

    public function Username() {
        if ($this->isMessage()) {
            return $this->update['message']['from']['username'] ? $this->update['message']['from']['username'] : null;
        }
    }

    public function isMessage() {
        return isset($this->update['message']);
    }
    
    public function isQuery() {
        return isset($this->update['callback_query']);
    }

    public function isBusinessMessage() {
        return isset($this->update['business_message']);
    }

    public function isMessageContact() {
        return $this->update['message']['contact'] ? true : false;
    }

    public function isChannelPost() {
        return $this->update['channel_post'] ? true : false;
    }

    public function Text() {
        if ($this->isMessage()) {
            return isset($this->update['message']['text']) ? $this->update['message']['text'] : '';
        } else if ($this->isQuery()) {
            return isset($this->update['callback_query']['data']) ? $this->update['callback_query']['data'] : '';
        } else if ($this->isBusinessMessage()) {
            return isset($this->update['business_message']['text']) ? $this->update['business_message']['text'] : '';
        }
    }

    public function FirstName() {
        if ($this->isMessage()) {
            return $this->update['message']['chat']['first_name'];
        } else if ($this->isQuery()) {
            return $this->update['callback_query']['from']['first_name'];
        }
    }

    public function PhoneNumber() {
        return $this->update['message']['contact']['phone_number'] ? $this->update['message']['contact']['phone_number'] : '';
    }

    public function sendMessage($chat_id, $text, $reply_markup=null, $parse_mode=null, $business_connection_id = null) {
        return $this->bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $reply_markup ? json_encode($reply_markup) : '',
            'parse_mode' => $parse_mode,
            'business_connection_id' => $business_connection_id
        ]);
    }

    public function sendDocument($chat_id, $document, $caption=null) {
        $this->bot('sendDocument', [
            'chat_id' => $chat_id,
            'document' => $document,
            'caption' => $caption
        ]);
    }
}
