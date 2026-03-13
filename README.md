# Chotto Motto Allergen Bot

Simple single-page web app for iPad service staff.

## Run locally

```bash
python3 -m http.server 8080
```

Then open `http://localhost:8080`.

## Data source

On every page load, the app pulls the latest rows from this Google Sheet:

`https://docs.google.com/spreadsheets/d/1K4tN344VgMMahoJd9bp-RoDwy0GW_0PlukaBwYOLPG0/edit?gid=0#gid=0`

## Feedback submission setup (GitHub Pages compatible)

The feedback dialog posts JSON to a Google Apps Script Web App URL configured in `index.html`:

```js
const FEEDBACK_WEBHOOK_URL = "https://script.google.com/macros/s/.../exec";
```

Expected payload:
- `staffName`
- `message`
- `timestamp`
- `source`

Your Apps Script should append these values as a new row in the **feedback** sheet tab.
