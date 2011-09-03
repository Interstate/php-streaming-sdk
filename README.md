Interstate Streaming SDK
========================

The Interstate Streaming SDK is a super easy SDK for working with the Interstate Streaming API. The SDK itself is only around 40 LOC and uses cURL. To use the SDK simply include `sdk.php`, instantiate a copy of the class and then call the `stream()` method with a single argument of a function to be called when an event is received.

For example:

```php
<?php

include 'sdk.php';

$oauth_token	= '';
$instance		= new InterstateStreaming( $oauth_token );

function event( $object ) {

	echo 'Received object: ' . json_encode( $object ) . "\n";

}

$instance->stream( 'event' );
```

If you are running PHP 5.3.0 you can also use a closure as the stream() method argument, like so:

```php
<?php

$instance->stream( function( $object ) {

	echo 'Received object: ' . json_encode( $object ) . "\n";

});
```
