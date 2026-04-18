import { createRequire } from 'module';
const require = createRequire(import.meta.url);
const { QPay, QPayError } = require('./qpay.js');

export { QPay, QPayError };
export default QPay;
