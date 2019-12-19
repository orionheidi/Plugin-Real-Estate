<?php
if ( isset( $_POST['post_title'] ) ) {

$nonce = acf_maybe_get_POST( 'update_nonce_field' );

if ( wp_verify_nonce( $nonce, 'update_action' ) ) {

$current_user_id = get_current_user_id();

if ( ( current_user_can( 'administrator' ) ) || ( $current_user_id == (int) $post->post_author ) ) {
$my_post = array(
'ID'         => acf_maybe_get_POST( 'post_id' ),
'post_title' => acf_maybe_get_POST( 'post_title' ),
'meta_input' => [
'subtitle' => acf_maybe_get_POST( 'subtitle' )
]
);

$updated = wp_update_post( $my_post );

}
} else {

print 'Sorry, your nonce did not verify.';
exit;
}
}
