/**
 * QPay Editor Integration
 * Supports Gutenberg (Blocks) and Classic Editor (TinyMCE)
 */

(function() {
    // 1. Gutenberg Block Registration
    if (window.wp && wp.blocks) {
        const { registerBlockType } = wp.blocks;
        const { el } = wp.element;
        const { TextControl, PanelBody, TextareaControl } = wp.components;
        const { InspectorControls } = wp.editor || wp.blockEditor;

        registerBlockType('qpay/payment-button', {
            title: 'QPay Payment Button',
            icon: 'money-alt',
            category: 'common',
            attributes: {
                amount: { type: 'string', default: '100' },
                label: { type: 'string', default: 'Pay Now' },
                description: { type: 'string', default: '' },
            },
            edit: function(props) {
                const { attributes: { amount, label, description }, setAttributes } = props;

                return [
                    el(InspectorControls, { key: 'inspector' },
                        el(PanelBody, { title: 'Payment Settings', initialOpen: true },
                            el(TextControl, {
                                label: 'Amount (BDT)',
                                value: amount,
                                onChange: (val) => setAttributes({ amount: val }),
                            }),
                            el(TextControl, {
                                label: 'Button Label',
                                value: label,
                                onChange: (val) => setAttributes({ label: val }),
                            }),
                            el(TextareaControl, {
                                label: 'Description',
                                value: description,
                                onChange: (val) => setAttributes({ description: val }),
                            })
                        )
                    ),
                    el('div', { className: 'qpay-block-preview', style: { padding: '20px', border: '2px dashed #6200ee', borderRadius: '8px', textAlign: 'center' } },
                        el('button', { style: { backgroundColor: '#6200ee', color: '#fff', padding: '10px 20px', border: 'none', borderRadius: '4px', cursor: 'default' } }, label),
                        el('div', { style: { marginTop: '10px', fontSize: '12px', color: '#666' } }, 'Amount: ' + amount + ' BDT')
                    )
                ];
            },
            save: function() {
                return null; // Rendered via PHP
            },
        });
    }

    // 2. Classic Editor (TinyMCE) Plugin
    if (window.tinymce) {
        tinymce.PluginManager.add('qpay_mce_button', function(editor, url) {
            editor.addButton('qpay_mce_button', {
                title: 'Insert QPay Button',
                icon: 'icon dashicons-money-alt',
                onclick: function() {
                    editor.windowManager.open({
                        title: 'QPay Button Settings',
                        body: [
                            { type: 'textbox', name: 'amount', label: 'Amount (BDT)', value: '100' },
                            { type: 'textbox', name: 'label', label: 'Button Label', value: 'Pay Now' },
                            { type: 'textbox', name: 'description', label: 'Payment Description', value: '' }
                        ],
                        onsubmit: function(e) {
                            editor.insertContent('[qpay_button amount="' + e.data.amount + '" label="' + e.data.label + '" description="' + e.data.description + '"]');
                        }
                    });
                }
            });
        });
    }
})();
