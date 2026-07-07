"""Placeholder backend - the actual application is a Laravel 11 app served on port 3000.
This FastAPI stub exists to satisfy the platform's supervisor configuration.
All application routes (including /api/*) are handled by the Laravel app.
"""
from fastapi import FastAPI
from fastapi.responses import RedirectResponse

app = FastAPI(title="Mahaveer Hospital - Laravel Redirect Stub")


@app.get("/api/health")
async def health():
    return {"status": "ok", "note": "Laravel app runs on port 3000"}


@app.get("/api/{path:path}")
async def redirect_to_laravel(path: str):
    return RedirectResponse(url=f"/{path}", status_code=307)
