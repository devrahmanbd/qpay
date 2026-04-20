/**
 * QPay WooCommerce Blocks Integration
 */
const settings = window.wc.wcSettings.getSetting( 'qpay_data', {} );
const label = window.wp.htmlEntities.decodeEntities( settings.title ) || window.wp.i18n.__( 'QPay', 'qpay' );

const Content = () => {
    return window.wp.htmlEntities.decodeEntities( settings.description || '' );
};

const QPayLabel = ( props ) => {
    return window.wp.element.createElement( 'div', { className: 'qpay-block-label-container', style: { display: 'flex', alignItems: 'center' } },
        window.wp.element.createElement( 'span', null, label ),
        settings.icon ? window.wp.element.createElement( 'img', { 
            src: settings.icon, 
            alt: label, 
            style: { marginLeft: '10px', maxHeight: '24px' } 
        } ) : null
    );
};

const QPay = {
    name: 'qpay',
    label: window.wp.element.createElement( QPayLabel ),
    content: window.wp.element.createElement( Content ),
    edit: window.wp.element.createElement( Content ),
    canMakePayment: () => true,
    ariaLabel: label,
    supports: {
        features: settings.supports,
    },
};

window.wc.wcBlocksRegistry.registerPaymentMethod( QPay );
