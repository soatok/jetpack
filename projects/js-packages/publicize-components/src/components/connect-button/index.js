import { Button } from '@automattic/jetpack-components';
import { useCallback, forwardRef } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { requestExternalAccess } from '../../utils/request-external-access.js';

const ConnectButton = forwardRef( ( { connectUrl, onClose, className = null, size = 'normal' }, ref ) => {
	const requestConnection = useCallback(
		() => requestExternalAccess( connectUrl, onClose ),
		[ connectUrl, onClose ]
	);
	return (
		<Button className={ className } variant="primary" onClick={ requestConnection } size={ size } ref={ ref }>
			{ __( 'Connect', 'jetpack' ) }
		</Button>
	);
} );

export default ConnectButton;
