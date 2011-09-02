<?php

class InterstateStreaming {

	const API_ROOT	= 'interstateapp.com';
	const API_PATH	= '/streaming/sub';
	
	private $_oauthToken;
	private $_https	= true;
	private $_callback = array();
	
	public function __construct( $oauthToken, $https = true ) {
		
		$this->_oauthToken	= $oauthToken;
		$this->_https		= $https;
	
	}
	
	public function stream( $callback ) {
		
		$curl						= curl_init();
		$this->_callback[ $curl ]	= $callback;	
	
		curl_setopt( $curl, CURLOPT_URL, ( ( $this->_https ) ? 'https://' : 'http://' ) . self::API_ROOT . self::API_PATH . '?oauth_token=' . $this->_oauthToken );
		curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $curl, CURLOPT_HTTP_VERSION, '1.0' );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_WRITEFUNCTION, array( $this, '_onWrite' ) );
		
		$i = curl_exec( $curl );
		
	}
	
	private function _onWrite( $data, $resp ) {

		if( is_callable( $this->_callback[ $data ] ) !== false ) {
		
			$this->_callback[ $data ]( json_decode( $resp ) );
		
		}
		
		return strlen( $resp );
	
	}
	
}