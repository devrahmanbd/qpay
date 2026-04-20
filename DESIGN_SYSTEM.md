# Qpay Design System (Stripe-Inspired)

This document defines the visual language and design tokens for the Qpay frontend, heavily inspired by the clean, spacious, and high-contrast aesthetic of Stripe.

## 🎨 Color Palette

### Primary (Indigo/Blurple)
- **Primary**: `#635BFF` (Vibrant Indigo)
- **Primary Hover**: `#5433FF` (Deep Blurple)
- **Primary Light**: `#E6E8FF` (Soft Wash)

### Backgrounds
- **Base**: `#FFFFFF` (Pure White)
- **Surface**: `#F6F9FC` (Off-white / Pearl)
- **Subtle**: `#F8FAFC` (Slate Tint)

### Typography (Slate/Gray)
- **Heading**: `#1A1F36` (Deep Charcoal)
- **Body**: `#4F566B` (Slate Gray)
- **Muted**: `#697386` (Medium Gray)

---

## 🔠 Typography
- **Typeface**: `Inter`, `-apple-system`, `BlinkMacSystemFont`, `"Segoe UI"`, `Roboto`, `sans-serif`
- **Headings**: Semi-bold to Bold (600-700) with generous tracking.
- **Body**: Regular (400) for readability.

---

## 💎 Components & Styling

### Buttons
- **Style**: Solid background, white text, 8px-12px border radius.
- **Shadow**: `0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)`
- **Hover**: Subtle lift (`transform: translateY(-1px)`) and deeper shadow.

### Cards
- **Background**: `#FFFFFF`
- **Border**: `1px solid #E3E8EE` (Very subtle)
- **Shadow**: `0 7px 14px 0 rgba(60, 66, 87, 0.08), 0 3px 6px 0 rgba(0, 0, 0, 0.12)`
- **Corner Radius**: `12px`

### Logo
- **Mark**: Clean, bold text mark.
- **Text**: `Qpay`
- **Weight**: `Bold (700)` or `Extra Bold (800)`
- **Color**: Primary Indigo (`#635BFF`)

---

## 🏗 Interaction Rules
1. **Spaciousness**: Minimum section padding of `py-24`.
2. **Transition**: All interactive elements (buttons, links) must use `transition: all 0.2s ease`.
3. **Focus**: Always use a soft indigo ring for keyboard focus states.
