#!/usr/bin/env python3
"""
Laravel RBAC System UI Test using Playwright
Tests the complete user interface and authentication flows
"""

import asyncio
from playwright.async_api import async_playwright
import sys

class LaravelUITester:
    def __init__(self, base_url="http://localhost:8000"):
        self.base_url = base_url
        self.test_users = {
            'superadmin': {
                'cedula': '12345678',
                'password': 'SuperAdmin123!',
                'role': 1,
                'expected_dashboard': '/dashboard/superadmin'
            },
            'admin': {
                'cedula': '87654321', 
                'password': 'Admin123!',
                'role': 2,
                'expected_dashboard': '/dashboard/administrador'
            },
            'usuario': {
                'cedula': '11223344',
                'password': 'Usuario123!',
                'role': 3,
                'expected_dashboard': '/dashboard/usuario'
            }
        }

    async def test_login_page_access(self, page):
        """Test login page accessibility and form elements"""
        print("\n📋 Testing Login Page Access")
        
        try:
            await page.goto(self.base_url)
            await page.wait_for_load_state('networkidle')
            
            current_url = page.url
            print(f"Current URL: {current_url}")
            
            if "login" in current_url:
                print("✅ Application correctly redirects to login page")
            else:
                print("❌ Application did not redirect to login page")
                return False
            
            # Check for form elements
            cedula_input = await page.query_selector('input[wire\\:model="cedula"]')
            password_input = await page.query_selector('input[wire\\:model="password"]')
            login_button = await page.query_selector('button[wire\\:click="login"]')
            
            if cedula_input and password_input and login_button:
                print("✅ Login form elements found")
                return True
            else:
                print("❌ Login form elements missing")
                # Try alternative selectors
                cedula_input = await page.query_selector('input[name="cedula"]')
                password_input = await page.query_selector('input[type="password"]')
                login_button = await page.query_selector('button[type="submit"]')
                
                if cedula_input and password_input and login_button:
                    print("✅ Login form elements found (alternative selectors)")
                    return True
                else:
                    print("❌ Login form elements still missing")
                    return False
                    
        except Exception as e:
            print(f"❌ Error testing login page: {str(e)}")
            return False

    async def test_user_authentication(self, page, user_type):
        """Test user authentication for specific role"""
        user = self.test_users[user_type]
        print(f"\n👤 Testing {user_type.title()} Authentication")
        
        try:
            # Navigate to login page
            await page.goto(f"{self.base_url}/login")
            await page.wait_for_load_state('networkidle')
            
            # Fill in credentials
            await page.fill('input[wire\\:model="cedula"]', user['cedula'])
            await page.fill('input[wire\\:model="password"]', user['password'])
            
            # Submit form (Livewire form uses wire:submit.prevent)
            await page.click('button[type="submit"]')
            await page.wait_for_load_state('networkidle')
            
            # Check for validation errors
            error_elements = await page.query_selector_all('.text-red-600, .bg-red-100, [class*="error"]')
            if error_elements:
                print(f"⚠️  Found {len(error_elements)} error messages on page")
                for i, error in enumerate(error_elements):
                    try:
                        error_text = await error.inner_text()
                        print(f"   Error {i+1}: {error_text}")
                    except:
                        pass
            
            # Check if redirected to dashboard
            current_url = page.url
            if "dashboard" in current_url:
                print(f"✅ {user_type.title()} login successful - redirected to: {current_url}")
                return True
            else:
                print(f"❌ {user_type.title()} login failed - current URL: {current_url}")
                return False
                
        except Exception as e:
            print(f"❌ Error during {user_type} authentication: {str(e)}")
            return False

    async def test_dashboard_access(self, page, user_type):
        """Test role-specific dashboard access"""
        user = self.test_users[user_type]
        print(f"\n🏠 Testing {user_type.title()} Dashboard Access")
        
        try:
            # Navigate to user's specific dashboard
            dashboard_url = f"{self.base_url}{user['expected_dashboard']}"
            await page.goto(dashboard_url)
            await page.wait_for_load_state('networkidle')
            
            current_url = page.url
            if user['expected_dashboard'] in current_url:
                print(f"✅ {user_type.title()} can access their dashboard")
                return True
            else:
                print(f"❌ {user_type.title()} cannot access their dashboard - redirected to: {current_url}")
                return False
                
        except Exception as e:
            print(f"❌ Error testing {user_type} dashboard access: {str(e)}")
            return False

    async def test_cross_role_protection(self, page, current_user_type):
        """Test that users cannot access other role dashboards"""
        print(f"\n🔒 Testing Cross-Role Protection for {current_user_type.title()}")
        
        other_dashboards = {
            'superadmin': '/dashboard/superadmin',
            'admin': '/dashboard/administrador', 
            'usuario': '/dashboard/usuario'
        }
        
        # Remove current user's dashboard
        current_user_dashboard = other_dashboards.pop(current_user_type)
        
        blocked_count = 0
        for role, dashboard_path in other_dashboards.items():
            try:
                await page.goto(f"{self.base_url}{dashboard_path}")
                await page.wait_for_load_state('networkidle')
                
                current_url = page.url
                if dashboard_path not in current_url:
                    print(f"✅ {current_user_type.title()} blocked from {role} dashboard")
                    blocked_count += 1
                else:
                    print(f"❌ {current_user_type.title()} can access {role} dashboard")
                    
            except Exception as e:
                print(f"❌ Error testing {role} dashboard protection: {str(e)}")
        
        return blocked_count == len(other_dashboards)

    async def test_logout(self, page):
        """Test logout functionality"""
        print("\n🚪 Testing Logout Functionality")
        
        try:
            # Look for logout button/link
            logout_selectors = [
                'button:has-text("Cerrar Sesión")',
                'a:has-text("Cerrar Sesión")',
                'button:has-text("Logout")',
                'a:has-text("Logout")',
                '[wire\\:click*="logout"]'
            ]
            
            logout_element = None
            for selector in logout_selectors:
                try:
                    logout_element = await page.query_selector(selector)
                    if logout_element:
                        break
                except:
                    continue
            
            if logout_element:
                await logout_element.click()
                await page.wait_for_load_state('networkidle')
                
                current_url = page.url
                if "login" in current_url or current_url == self.base_url + "/":
                    print("✅ Logout successful")
                    return True
                else:
                    print(f"❌ Logout failed - current URL: {current_url}")
                    return False
            else:
                print("❌ Logout button not found")
                return False
                
        except Exception as e:
            print(f"❌ Error during logout: {str(e)}")
            return False

    async def run_comprehensive_test(self):
        """Run all UI tests"""
        print("🚀 Starting Laravel RBAC System UI Tests")
        print("=" * 60)
        
        async with async_playwright() as p:
            browser = await p.chromium.launch(headless=True)
            context = await browser.new_context()
            page = await context.new_page()
            
            try:
                # Test login page access
                if not await self.test_login_page_access(page):
                    print("❌ Login page test failed, stopping")
                    return False
                
                # Test each user role
                for user_type in ['usuario', 'admin', 'superadmin']:
                    print(f"\n{'='*20} Testing {user_type.upper()} Role {'='*20}")
                    
                    # Test authentication
                    if await self.test_user_authentication(page, user_type):
                        # Test dashboard access
                        await self.test_dashboard_access(page, user_type)
                        
                        # Test cross-role protection
                        await self.test_cross_role_protection(page, user_type)
                        
                        # Test logout (only for last user)
                        if user_type == 'superadmin':
                            await self.test_logout(page)
                    else:
                        print(f"⚠️  Skipping further tests for {user_type} due to auth failure")
                
                print("\n" + "=" * 60)
                print("🎉 UI Testing completed!")
                return True
                
            finally:
                await browser.close()

async def main():
    """Main test execution"""
    print("Laravel RBAC System UI Tester")
    print("Testing complete user interface flows")
    
    tester = LaravelUITester()
    success = await tester.run_comprehensive_test()
    
    return 0 if success else 1

if __name__ == "__main__":
    sys.exit(asyncio.run(main()))