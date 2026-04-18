# QPay Integration Guide: Choosing Your Plugin

To provide the best checkout experience for your customers, we offer two distinct WordPress-based integrations. Depending on your business model and website structure, you may choose either **QPay for WordPress** or the **QPay WooCommerce Gateway**.

---

## At a Glance: Comparison Table

| Feature | QPay for WordPress (Full Suite) | QPay WooCommerce (Standalone) |
| :--- | :--- | :--- |
| **Best For** | General WP sites, Charities, Service Providers | Dedicated e-Commerce stores |
| **Storefront** | Optional (via built-in Woo gateway) | Required (strictly WooCommerce) |
| **Payment Buttons** | Yes (Shortcodes) | No |
| **Donation Forms** | Yes (Advanced Form Builder) | No |
| **Lead Generation** | Yes (Custom Payment Forms) | No |
| **Performance** | Feature-rich (Moderate) | Lightweight (Highly Optimized) |
| **Admin Dashboard**| Full Transaction Manager & Reports | Native WooCommerce Order Flow |

---

## 1. QPay for WordPress (The All-in-One Suite)

**QPay for WordPress** is our most versatile plugin. It is designed for users who need to accept payments in multiple ways across their entire site, not just at a traditional checkout page.

### Key Use Cases:
- **Donation Landing Pages**: Create high-converting donation forms with preset amounts (e.g., $10, $50, $100).
- **Service Invoicing**: Send clients to a simple page with a "Pay Now" button for a fixed consulting fee.
- **Custom Lead Forms**: Collect customer information (Name, Email, Phone) along with a payment in a single step.
- **Hybrid Sites**: You have a blog or portfolio but also sell a few items via WooCommerce on the side.

### Exclusive Features:
- **Shortcode System**: Use `[qpay_button]`, `[qpay_form]`, and `[qpay_donate]` anywhere (pages, posts, widgets).
- **Form Builder**: Build multi-field payment forms directly from the WordPress Admin without touching code.
- **Role Management**: Assign "QPay Merchant" roles to team members who only need to manage payments without full admin access.

---

## 2. QPay WooCommerce Gateway (Standalone)

The **QPay WooCommerce Gateway** is a specialized, performance-first plugin. It is stripped of all non-essential features to provide the fastest and most reliable checkout experience for high-traffic stores.

### Key Use Cases:
- **Dedicated Online Stores**: Your site is primarily a shop, and you want to minimize plugin bloat.
- **Performance-Oriented Sites**: You prioritize page load speed and Core Web Vitals.
- **Simple Stores**: You only need to accept payments at the WooCommerce checkout page and don't need buttons or forms elsewhere.

### Exclusive Features:
- **Lean Codebase**: 0% bloat. No background tasks or shortcodes that consume resources.
- **Enhanced Block Support**: Built from the ground up to support the new WooCommerce "Checkout" and "Cart" blocks.
- **Direct Order Mapping**: Deeply integrated with WooCommerce order statuses and native refund workflows.

---

## Decision Logic: Which should I pick?

- **"I have a shop and want to accept payments at checkout."**
  👉 Pick **QPay WooCommerce Gateway**.
- **"I want to put 'Donate' buttons on my blog posts and also have a small shop."**
  👉 Pick **QPay for WordPress**.
- **"I only need a simple way to collect registration fees for an event."**
  👉 Pick **QPay for WordPress**.
- **"I am a developer building a high-performance store for a client."**
  👉 Pick **QPay WooCommerce Gateway**.

---

## Installation & Support

Both plugins share the same core security architecture (`qp_` & `pk_` keys) and are maintained with the same high standards for security and reliability.

- **Need help?** Visit our [Merchant Help Center](https://qpay.com/help)
- **Developer Docs**: [docs.qpay.com](https://docs.qpay.com)
