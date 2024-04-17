'use strict';
Object.defineProperty( exports, '__esModule', { value: ! 0 } ), ( exports.default = void 0 );
const _react = require( 'react' ),
	_socialLogo = _interopRequireDefault( require( './social-logo' ) ),
	_socialLogoData = require( './social-logo-data' );
require( './example.css' );
/**
 *
 * @param a
 */
function _interopRequireDefault( a ) {
	return a && a.__esModule ? a : { default: a };
}
/**
 *
 * @param a
 * @param b
 */
function _slicedToArray( a, b ) {
	return (
		_arrayWithHoles( a ) ||
		_iterableToArrayLimit( a, b ) ||
		_unsupportedIterableToArray( a, b ) ||
		_nonIterableRest()
	);
}
/**
 *
 */
function _nonIterableRest() {
	throw new TypeError(
		'Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
	);
}
/**
 *
 * @param a
 * @param b
 */
function _unsupportedIterableToArray( a, b ) {
	if ( a ) {
		if ( 'string' === typeof a ) {
			return _arrayLikeToArray( a, b );
		}
		let c = Object.prototype.toString.call( a ).slice( 8, -1 );
		return (
			'Object' === c && a.constructor && ( c = a.constructor.name ),
			'Map' === c || 'Set' === c
				? Array.from( a )
				: 'Arguments' === c || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test( c )
				? _arrayLikeToArray( a, b )
				: void 0
		);
	}
}
/**
 *
 * @param a
 * @param b
 */
function _arrayLikeToArray( a, b ) {
	( null == b || b > a.length ) && ( b = a.length );
	for ( var c = 0, d = Array( b ); c < b; c++ ) {
		d[ c ] = a[ c ];
	}
	return d;
}
/**
 *
 * @param b
 * @param c
 */
function _iterableToArrayLimit( b, c ) {
	let d =
		null == b
			? null
			: ( 'undefined' !== typeof Symbol && b[ Symbol.iterator ] ) || b[ '@@iterator' ];
	if ( null != d ) {
		let g,
			h,
			j,
			k,
			l = [],
			a = ! 0,
			m = ! 1;
		try {
			if ( ( ( j = ( d = d.call( b ) ).next ), 0 === c ) ) {
				if ( Object( d ) !== d ) {
					return;
				}
				a = ! 1;
			} else {
				for (
					;
					! ( a = ( g = j.call( d ) ).done ) && ( l.push( g.value ), l.length !== c );
					a = ! 0
				) {}
			}
		} catch ( a ) {
			( m = ! 0 ), ( h = a );
		} finally {
			try {
				if ( ! a && null != d.return && ( ( k = d.return() ), Object( k ) !== k ) ) {
					return;
				}
			} finally {
				if ( m ) {
					throw h;
				}
			}
		}
		return l;
	}
}
/**
 *
 * @param a
 */
function _arrayWithHoles( a ) {
	if ( Array.isArray( a ) ) {
		return a;
	}
}
/**
 *
 */
function SocialLogosExample() {
	const a = this,
		b = ( 0, _react.useState )( ! 1 ),
		c = _slicedToArray( b, 2 ),
		d = c[ 0 ],
		f = c[ 1 ],
		g = ( 0, _react.useState )( ! 0 ),
		h = _slicedToArray( g, 2 ),
		i = h[ 0 ],
		j = h[ 1 ],
		k = d ? 24 : 48,
		l = function ( a ) {
			const b = '<SocialLogo icon="'.concat( a, '" size="' ).concat( k, '" />' );
			window.prompt( 'Copy component code:', b );
		},
		m = _socialLogoData.SocialLogoData.map( function ( b ) {
			return /*#__PURE__*/ React.createElement(
				'div',
				{ key: b.name },
				/*#__PURE__*/ React.createElement( _socialLogo.default, {
					icon: b.name,
					size: k,
					onClick: l.bind( a, b.name ),
				} ),
				i && /*#__PURE__*/ React.createElement( 'p', null, b.name )
			);
		} );
	return /*#__PURE__*/ React.createElement(
		'div',
		{ className: 'social-logos-example' },
		/*#__PURE__*/ React.createElement( 'h1', null, 'Social Logos' ),
		/*#__PURE__*/ React.createElement(
			'div',
			{ className: 'display-control-group' },
			/*#__PURE__*/ React.createElement(
				'div',
				{ className: 'display-control' },
				/*#__PURE__*/ React.createElement( 'h4', null, 'Small icons' ),
				/*#__PURE__*/ React.createElement(
					'label',
					{ className: 'switch' },
					/*#__PURE__*/ React.createElement( 'input', {
						type: 'checkbox',
						onChange: function handleSmallIconsToggle( a ) {
							f( a.target.checked );
						},
						checked: d,
					} ),
					/*#__PURE__*/ React.createElement( 'span', { className: 'handle' } )
				)
			),
			/*#__PURE__*/ React.createElement(
				'div',
				{ className: 'display-control' },
				/*#__PURE__*/ React.createElement( 'h4', null, 'Icon names' ),
				/*#__PURE__*/ React.createElement(
					'label',
					{ className: 'switch' },
					/*#__PURE__*/ React.createElement( 'input', {
						type: 'checkbox',
						onChange: function handleIconNamesToggle( a ) {
							j( a.target.checked );
						},
						checked: i,
					} ),
					/*#__PURE__*/ React.createElement( 'span', { className: 'handle' } ),
					/*#__PURE__*/ React.createElement( 'span', {
						className: 'switch-label',
						'data-on': 'On',
						'data-off': 'Off',
					} )
				)
			)
		),
		/*#__PURE__*/ React.createElement( 'div', { className: 'icons' }, m ),
		/*#__PURE__*/ React.createElement(
			'p',
			null,
			/*#__PURE__*/ React.createElement(
				'a',
				{ href: 'https://github.com/Automattic/social-logos' },
				'GitHub'
			)
		)
	);
}
const _default = ( exports.default = SocialLogosExample );
