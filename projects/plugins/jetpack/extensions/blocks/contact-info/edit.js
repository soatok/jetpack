import { InnerBlocks } from '@wordpress/block-editor';
import classnames from 'classnames';

const ALLOWED_BLOCKS = [
	'jetpack/markdown',
	'jetpack/address',
	'jetpack/email',
	'jetpack/image',
	'jetpack/phone',
	'jetpack/map',
	'jetpack/name',
	'jetpack/business-hours',
	'core/paragraph',
	'core/heading',
	'core/gallery',
	'core/list',
	'core/quote',
	'core/shortcode',
	'core/audio',
	'core/code',
	'core/cover',
	'core/html',
	'core/separator',
	'core/spacer',
	'core/subhead',
	'core/video',
];

const TEMPLATE = [
	[ 'jetpack/image' ],
	[ 'jetpack/name' ],
	[ 'jetpack/email' ],
	[ 'jetpack/phone' ],
	[ 'jetpack/address' ],
];

const ContactInfoEdit = props => {
	const { isSelected } = props;

	return (
		<div
			className={ classnames( {
				'jetpack-contact-info-block': true,
				'is-selected': isSelected,
			} ) }
		>
			<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } templateLock={ false } template={ TEMPLATE } />
		</div>
	);
};

export default ContactInfoEdit;
