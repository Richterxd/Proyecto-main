#!/usr/bin/env python3
"""
Simple Laravel RBAC System UI Test with Screenshots
"""

import asyncio
from playwright.async_api import async_playwright
import sys

async def test_login_flow():
    async with async_playwright() as p:
        browser = await p.chromium.launch(headless=True)
        context = await browser.new_context()
        page = await context.new_page()
        
        try:
            print("🚀 Testing Laravel Login Flow")
            
            # Navigate to application
            print("\n1. Navigating to application...")
            await page.goto("http://localhost:8000")
            await page.wait_for_load_state('networkidle')
            
            current_url = page.url
            print(f"Current URL: {current_url}")
            
            # Take screenshot of initial page
            await page.screenshot(path="step1_initial.png")
            print("📸 Screenshot saved: step1_initial.png")
            
            # Navigate to login if not already there
            if "login" not in current_url:
                print("\n2. Navigating to login page...")
                await page.goto("http://localhost:8000/login")
                await page.wait_for_load_state('networkidle')
            
            # Take screenshot of login page
            await page.screenshot(path="step2_login_page.png")
            print("📸 Screenshot saved: step2_login_page.png")
            
            # Check form elements
            print("\n3. Checking form elements...")
            
            # Get all inputs
            inputs = await page.query_selector_all('input')
            print(f"Found {len(inputs)} input elements")
            
            for i, input_elem in enumerate(inputs):
                try:
                    input_type = await input_elem.get_attribute('type')
                    input_name = await input_elem.get_attribute('name')
                    input_id = await input_elem.get_attribute('id')
                    wire_model = await input_elem.get_attribute('wire:model')
                    print(f"  Input {i+1}: type='{input_type}', name='{input_name}', id='{input_id}', wire:model='{wire_model}'")
                except Exception as e:
                    print(f"  Input {i+1}: Error getting attributes - {e}")
            
            # Try to fill the form
            print("\n4. Attempting to fill form...")
            
            try:
                # Try different selectors for cedula
                cedula_filled = False
                cedula_selectors = ['input[wire\\:model="cedula"]', 'input[name="cedula"]', 'input[id="cedula"]']
                
                for selector in cedula_selectors:
                    try:
                        await page.fill(selector, '12345678')
                        print(f"✅ Filled cedula using selector: {selector}")
                        cedula_filled = True
                        break
                    except:
                        continue
                
                if not cedula_filled:
                    print("❌ Could not fill cedula field")
                
                # Try different selectors for password
                password_filled = False
                password_selectors = ['input[wire\\:model="password"]', 'input[type="password"]', 'input[id="password"]']
                
                for selector in password_selectors:
                    try:
                        await page.fill(selector, 'SuperAdmin123!')
                        print(f"✅ Filled password using selector: {selector}")
                        password_filled = True
                        break
                    except:
                        continue
                
                if not password_filled:
                    print("❌ Could not fill password field")
                
                # Take screenshot after filling
                await page.screenshot(path="step3_form_filled.png")
                print("📸 Screenshot saved: step3_form_filled.png")
                
                # Try to submit
                print("\n5. Attempting to submit form...")
                
                submit_selectors = ['button[type="submit"]', 'input[type="submit"]', 'button:has-text("Iniciar")']
                
                for selector in submit_selectors:
                    try:
                        await page.click(selector)
                        print(f"✅ Clicked submit using selector: {selector}")
                        break
                    except:
                        continue
                
                # Wait for response
                await page.wait_for_load_state('networkidle', timeout=10000)
                
                # Take screenshot after submit
                await page.screenshot(path="step4_after_submit.png")
                print("📸 Screenshot saved: step4_after_submit.png")
                
                final_url = page.url
                print(f"Final URL: {final_url}")
                
                if "dashboard" in final_url:
                    print("✅ Login successful - redirected to dashboard")
                elif "login" in final_url:
                    print("❌ Login failed - still on login page")
                    
                    # Check for error messages more thoroughly
                    error_selectors = [
                        '.text-red-600', '.bg-red-100', '.text-red-500', 
                        '[class*="error"]', '[class*="red"]', '.alert-danger'
                    ]
                    
                    all_errors = []
                    for selector in error_selectors:
                        try:
                            elements = await page.query_selector_all(selector)
                            for element in elements:
                                try:
                                    text = await element.inner_text()
                                    if text.strip():
                                        all_errors.append(text.strip())
                                except:
                                    pass
                        except:
                            pass
                    
                    if all_errors:
                        print("Found error messages:")
                        for error in set(all_errors):  # Remove duplicates
                            print(f"  - {error}")
                    else:
                        print("No error messages found - checking page content...")
                        
                        # Get page content to see what's happening
                        page_content = await page.content()
                        if "auth.failed" in page_content:
                            print("  - Found 'auth.failed' in page content")
                        if "validation" in page_content.lower():
                            print("  - Found 'validation' in page content")
                        if "error" in page_content.lower():
                            print("  - Found 'error' in page content")
                        
                        # Check if form was actually submitted
                        if "wire:loading" in page_content:
                            print("  - Livewire loading states found")
                        if "wire:submit" in page_content:
                            print("  - Livewire submit found")
                else:
                    print(f"❓ Unexpected redirect to: {final_url}")
                
            except Exception as e:
                print(f"❌ Error during form interaction: {str(e)}")
                await page.screenshot(path="error_screenshot.png")
                print("📸 Error screenshot saved: error_screenshot.png")
            
        finally:
            await browser.close()

if __name__ == "__main__":
    asyncio.run(test_login_flow())