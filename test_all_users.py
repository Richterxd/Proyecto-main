#!/usr/bin/env python3
"""
Test all user credentials and check for authentication issues
"""

import asyncio
from playwright.async_api import async_playwright

async def test_all_users():
    users = [
        {'cedula': '12345678', 'password': 'SuperAdmin123!', 'role': 'SuperAdmin'},
        {'cedula': '87654321', 'password': 'Admin123!', 'role': 'Admin'},
        {'cedula': '11223344', 'password': 'Usuario123!', 'role': 'Usuario'}
    ]
    
    async with async_playwright() as p:
        browser = await p.chromium.launch(headless=True)
        
        for user in users:
            print(f"\n🧪 Testing {user['role']} - Cedula: {user['cedula']}")
            
            context = await browser.new_context()
            page = await context.new_page()
            
            try:
                # Navigate to login
                await page.goto("http://localhost:8000/login")
                await page.wait_for_load_state('networkidle')
                
                # Fill form
                await page.fill('input[wire\\:model="cedula"]', user['cedula'])
                await page.fill('input[wire\\:model="password"]', user['password'])
                
                # Submit and wait longer
                await page.click('button[type="submit"]')
                
                # Wait for Livewire to process (longer timeout)
                try:
                    await page.wait_for_url("**/dashboard**", timeout=15000)
                    print(f"✅ {user['role']} login successful!")
                    
                    # Take screenshot of dashboard
                    await page.screenshot(path=f"dashboard_{user['role'].lower()}.png")
                    print(f"📸 Dashboard screenshot: dashboard_{user['role'].lower()}.png")
                    
                except:
                    # Still on login page
                    await page.wait_for_load_state('networkidle')
                    current_url = page.url
                    print(f"❌ {user['role']} login failed - URL: {current_url}")
                    
                    # Check for any error messages
                    error_text = await page.evaluate("""() => {
                        const errorElements = Array.from(document.querySelectorAll('.text-red-600, .bg-red-100, [class*="error"]'));
                        return errorElements.map(el => el.textContent).join(", ");
                    }""")
                    
                    if error_text:
                        print(f"   Error: {error_text}")
                    else:
                        print("   No visible error messages")
                        
                        # Check if form values are still there
                        cedula_value = await page.input_value('input[wire\\:model="cedula"]')
                        print(f"   Cedula field value: '{cedula_value}'")
                        
                        # Check page title
                        title = await page.title()
                        print(f"   Page title: {title}")
                
            except Exception as e:
                print(f"❌ Error testing {user['role']}: {str(e)}")
            
            finally:
                await context.close()
        
        await browser.close()

if __name__ == "__main__":
    asyncio.run(test_all_users())