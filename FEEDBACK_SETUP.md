# Pure client-side feedback setup (GitHub Pages compatible)

Yes — this can work **purely client-side** on GitHub Pages by using **EmailJS**.

## Why this works

- GitHub Pages can run browser JavaScript.
- EmailJS exposes a public API that can be called directly from the browser.
- No custom backend/server is required.

## 1) Create EmailJS resources

In EmailJS dashboard:

1. Create/connect an email service (Gmail/Outlook/SMTP).
2. Create an email template.
3. Copy these values:
   - `serviceId`
   - `templateId`
   - `publicKey`

## 2) Configure `index.html`

Set these values in `FEEDBACK_EMAILJS`:

```js
const FEEDBACK_EMAILJS = {
  serviceId: "YOUR_SERVICE_ID",
  templateId: "YOUR_TEMPLATE_ID",
  publicKey: "YOUR_PUBLIC_KEY"
};
```

## 3) Template params sent by the app

The feedback form sends:

- `staff_name`
- `message`
- `timestamp`
- `source` (always `Big Al`)

Map those in your EmailJS template so they appear in the email body/subject.

## Notes

- This is client-side, so keys are visible in page source (use EmailJS public key only).
- Use EmailJS rate limits / anti-spam options for abuse protection.
- If you later want stronger security/control, move to a backend endpoint.
