const qpay_data = window.wc.wcSettings.getSetting('qpay_data', {});
const qpay_label = window.wp.htmlEntities.decodeEntities(qpay_data.title) || 'QPay';
const qpay_Description = () => {
    return window.wp.element.createElement('div', {
        className: 'qpay-blocks-description',
        dangerouslySetInnerHTML: { __html: qpay_data.description }
    });
};

const QPay_Block_Gateway = {
    name: 'qpay',
    label: qpay_label,
    content: window.wp.element.createElement(qpay_Description),
    edit: window.wp.element.createElement(qpay_Description),
    canMakePayment: () => true,
    ariaLabel: qpay_label,
    supports: {
        features: qpay_data.supports || ['products'],
    },
};

window.wc.wcBlocksRegistry.registerPaymentMethod(QPay_Block_Gateway);
