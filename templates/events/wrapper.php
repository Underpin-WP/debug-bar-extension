<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! isset( $template ) || ! $template instanceof Debug_Bar_Panel ) {
	return;
}

foreach ( $template->get_logger() as $value ): ?>

	<strong>Code:</strong> <?= var_export( $value->code ) ?><br/>
	<strong>Message:</strong> <?= var_export( $value->message ) ?><br/>
	<strong>Ref:</strong> <?= var_export( $value->ref ) ?><br/>
	<strong>Context:</strong> <?= var_export( $value->context ) ?><br/>

	<?php foreach ( $value->data as $key => $datum ): ?>
		<strong><?= ucfirst( $key ) ?>:</strong> <?= var_export( $datum ) ?><br/>
	<?php endforeach; ?>
	<hr>
<?php endforeach; ?>
