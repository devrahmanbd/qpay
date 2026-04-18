export interface QPayOptions {
  baseUrl?: string;
  timeout?: number;
}

export interface CreatePaymentParams {
  amount: number;
  currency?: string;
  customer_email?: string;
  customer_name?: string;
  customer_phone?: string;
  payment_method?: string;
  callback_url?: string;
  success_url?: string;
  cancel_url?: string;
  metadata?: Record<string, unknown>;
  idempotency_key?: string;
}

export interface Payment {
  id: string;
  object: 'payment';
  amount: number;
  currency: string;
  status: 'pending' | 'processing' | 'completed' | 'failed' | 'refunded';
  test_mode: boolean;
  customer_email?: string;
  customer_name?: string;
  payment_method?: string;
  transaction_id?: string;
  checkout_url?: string;
  redirect_url?: string;
  fees?: number;
  net_amount?: number;
  metadata?: Record<string, unknown>;
  created_at: string;
  updated_at: string;
}

export interface PaymentList {
  object: 'list';
  data: Payment[];
  has_more: boolean;
  total_count: number;
}

export interface ListPaymentsParams {
  limit?: number;
  offset?: number;
  status?: string;
}

export interface Refund {
  id: string;
  object: 'refund';
  payment_id: string;
  amount: number;
  status: string;
  reason?: string;
  created_at: string;
}

export interface Balance {
  object: 'balance';
  available: number;
  pending: number;
  currency: string;
}

export interface PaymentMethod {
  id: string;
  name: string;
  type: string;
  enabled: boolean;
}

export declare class QPay {
  static VERSION: string;
  static API_VERSION: string;
  readonly isTestMode: boolean;

  constructor(apiKey: string, options?: QPayOptions);

  createPayment(params: CreatePaymentParams): Promise<Payment>;
  verifyPayment(paymentId: string): Promise<Payment>;
  getPaymentStatus(paymentId: string): Promise<Payment>;
  listPayments(params?: ListPaymentsParams): Promise<PaymentList>;
  createRefund(paymentId: string, reason?: string): Promise<Refund>;
  getBalance(): Promise<Balance>;
  getPaymentMethods(): Promise<PaymentMethod[]>;

  static verifyWebhookSignature(
    payload: string,
    signatureHeader: string,
    secret: string,
    tolerance?: number
  ): boolean;
}

export declare class QPayError extends Error {
  name: 'QPayError';
  httpCode: number;
  errorCode: string;
  responseBody: Record<string, unknown>;

  constructor(
    message: string,
    httpCode: number,
    errorCode: string,
    responseBody: Record<string, unknown>
  );
}

export default QPay;
