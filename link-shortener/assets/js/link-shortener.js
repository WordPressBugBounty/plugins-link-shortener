( function( $ ) {
	/**
	 * Generate random string.
	 */
	var ls_generate_link = function( length = 6 ) {
		var result           = '';
		var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		var charactersLength = characters.length;
		for ( var i = 0; i < length; i++ ) {
			result += characters.charAt(Math.floor(Math.random() * charactersLength));
		}
		return result;
	}

	/**
	 * Click to generate shortlink.
	 */
	$( document ).on( 'click', '[data-ls_url]', function( event ) {
		var randomString = ls_generate_link();
		var postID = $( this ).data( 'ls_post_id' );
		var postLink = $( this ).data( 'ls_url' ) + postID + '-' + randomString;
		$( '.ls-preview a' ).attr( 'href', postLink );
		$( '.ls-preview a' ).html( postLink );
		$( 'input[name="shortener-link"]' ).val( postID + '-' + randomString );
		if ( $( '#sample-permalink' ).length > 0 ) {
			$( '#sample-permalink' ).html( '<a href="'+ postLink +'">'+ $( this ).data( 'ls_url' ) +'<span id="editable-post-name">'+ postID + '-' + randomString +'</span>/</a>' );
			$( '#editable-post-name-full' ).text( postID + '-' + randomString );
		}
		event.preventDefault();
	} );
	if ( $( 'body' ).hasClass( 'post-new-php' ) ) {
		$( '[data-ls_url]' ).click();
	}
} )( jQuery );