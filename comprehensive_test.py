#!/usr/bin/env python3
"""
Comprehensive Laravel RBAC System Test
Tests authentication, role-based access, and dashboard functionality
"""

import asyncio
from playwright.async_api import async_playwright
import sys

class ComprehensiveRBACTest:
    def __init__(self):
        self.base_url = "http://localhost:8000"
        self.test_users = {
            'superadmin': {
                'cedula': '12345678',
                'password': 'SuperAdmin123!',
                'role': 1,
                'dashboard': '/dashboard/superadmin',
                'name': 'SuperAdmin'
            },
            'admin': {
                'cedula': '87654321', 
                'password': 'Admin123!',
                'role': 2,
                'dashboard': '/dashboard/administrador',
                'name': 'Admin'
            },
            'usuario': {
                'cedula': '11223344',
                'password': 'Usuario123!',
                'role': 3,
                'dashboard': '/dashboard/usuario',
                'name': 'Usuario'
            }
        }
        self.results = {
            'login_tests': {},
            'dashboard_access': {},
            'cross_role_protection': {},
            'ui_elements': {}
        }

    async def test_user_login(self, browser, user_key):
        """Test login for a specific user"""
        user = self.test_users[user_key]
        print(f"\n👤 Testing {user['name']} Login (Cedula: {user['cedula']})")
        
        context = await browser.new_context()
        page = await context.new_page()
        
        try:
            # Navigate to login
            await page.goto(f"{self.base_url}/login")
            await page.wait_for_load_state('networkidle')
            
            # Fill credentials
            await page.fill('input[wire\\:model="cedula"]', user['cedula'])
            await page.fill('input[wire\\:model="password"]', user['password'])
            
            # Submit form
            await page.click('button[type="submit"]')
            
            # Wait for redirect (give Livewire time to process)
            await page.wait_for_load_state('networkidle')
            await asyncio.sleep(2)  # Additional wait for Livewire
            
            current_url = page.url
            
            if "dashboard" in current_url:
                print(f"✅ {user['name']} login successful - redirected to: {current_url}")
                self.results['login_tests'][user_key] = True
                
                # Take screenshot of dashboard
                await page.screenshot(path=f"dashboard_{user_key}.png", full_page=False)
                print(f"📸 Dashboard screenshot saved: dashboard_{user_key}.png")
                
                return page, context  # Return for further testing
            else:
                print(f"❌ {user['name']} login failed - still at: {current_url}")
                self.results['login_tests'][user_key] = False
                
                # Check for error messages
                error_text = await page.evaluate("""() => {
                    const errorElements = Array.from(document.querySelectorAll('.text-red-600, .bg-red-100, [class*="error"]'));
                    return errorElements.map(el => el.textContent.trim()).filter(text => text).join(", ");
                }""")
                
                if error_text:
                    print(f"   Error messages: {error_text}")
                
                await context.close()
                return None, None
                
        except Exception as e:
            print(f"❌ Error during {user['name']} login: {str(e)}")
            self.results['login_tests'][user_key] = False
            await context.close()
            return None, None

    async def test_dashboard_functionality(self, page, user_key):
        """Test dashboard-specific functionality"""
        user = self.test_users[user_key]
        print(f"\n🏠 Testing {user['name']} Dashboard Functionality")
        
        try:
            # Check if we're on the correct dashboard
            current_url = page.url
            if user['dashboard'] in current_url:
                print(f"✅ Correct dashboard access: {current_url}")
                self.results['dashboard_access'][user_key] = True
                
                # Test role-specific elements
                if user_key == 'superadmin':
                    await self.test_superadmin_dashboard(page)
                elif user_key == 'admin':
                    await self.test_admin_dashboard(page)
                elif user_key == 'usuario':
                    await self.test_usuario_dashboard(page)
                    
            else:
                print(f"❌ Wrong dashboard - expected {user['dashboard']}, got {current_url}")
                self.results['dashboard_access'][user_key] = False
                
        except Exception as e:
            print(f"❌ Error testing {user['name']} dashboard: {str(e)}")
            self.results['dashboard_access'][user_key] = False

    async def test_superadmin_dashboard(self, page):
        """Test SuperAdmin specific functionality"""
        print("   🔧 Testing SuperAdmin features...")
        
        # Check for tabs/sections
        tabs = ['Resumen', 'Gestión de Usuarios', 'Solicitudes', 'Visitas']
        found_tabs = []
        
        for tab in tabs:
            try:
                tab_element = await page.query_selector(f'text="{tab}"')
                if tab_element:
                    found_tabs.append(tab)
            except:
                pass
        
        print(f"   📋 Found tabs: {', '.join(found_tabs) if found_tabs else 'None'}")
        
        # Check for user management elements
        user_elements = await page.query_selector_all('text="Usuario"')
        print(f"   👥 User management elements: {len(user_elements)}")
        
        self.results['ui_elements']['superadmin'] = {
            'tabs': found_tabs,
            'user_elements': len(user_elements)
        }

    async def test_admin_dashboard(self, page):
        """Test Admin specific functionality"""
        print("   📊 Testing Admin features...")
        
        # Check for pending solicitudes
        solicitudes = await page.query_selector_all('text="Pendiente"')
        print(f"   📝 Pending solicitudes found: {len(solicitudes)}")
        
        # Check for ámbitos filter
        ambito_filter = await page.query_selector('select')
        if ambito_filter:
            print("   🔍 Ámbitos filter found")
        else:
            print("   ❌ Ámbitos filter not found")
        
        self.results['ui_elements']['admin'] = {
            'pending_solicitudes': len(solicitudes),
            'has_filter': ambito_filter is not None
        }

    async def test_usuario_dashboard(self, page):
        """Test Usuario specific functionality"""
        print("   📋 Testing Usuario features...")
        
        # Check for own solicitudes
        solicitudes = await page.query_selector_all('text="Solicitud"')
        print(f"   📝 Own solicitudes found: {len(solicitudes)}")
        
        # Check for create button (should be non-functional)
        create_button = await page.query_selector('button:has-text("Crear")')
        if create_button:
            print("   ➕ Create button found")
        else:
            print("   ❌ Create button not found")
        
        self.results['ui_elements']['usuario'] = {
            'solicitudes': len(solicitudes),
            'has_create_button': create_button is not None
        }

    async def test_cross_role_access(self, browser, authenticated_user):
        """Test that users cannot access other role dashboards"""
        user = self.test_users[authenticated_user]
        print(f"\n🔒 Testing Cross-Role Access Protection for {user['name']}")
        
        other_dashboards = {
            'superadmin': '/dashboard/superadmin',
            'admin': '/dashboard/administrador',
            'usuario': '/dashboard/usuario'
        }
        
        # Remove current user's dashboard
        del other_dashboards[authenticated_user]
        
        context = await browser.new_context()
        page = await context.new_page()
        
        # First login as the user
        await page.goto(f"{self.base_url}/login")
        await page.wait_for_load_state('networkidle')
        await page.fill('input[wire\\:model="cedula"]', user['cedula'])
        await page.fill('input[wire\\:model="password"]', user['password'])
        await page.click('button[type="submit"]')
        await page.wait_for_load_state('networkidle')
        await asyncio.sleep(2)
        
        blocked_count = 0
        for role, dashboard_url in other_dashboards.items():
            try:
                await page.goto(f"{self.base_url}{dashboard_url}")
                await page.wait_for_load_state('networkidle')
                
                current_url = page.url
                if dashboard_url not in current_url:
                    print(f"   ✅ Blocked from {role} dashboard - redirected to {current_url}")
                    blocked_count += 1
                else:
                    print(f"   ❌ Can access {role} dashboard")
                    
            except Exception as e:
                print(f"   ❌ Error testing {role} dashboard: {str(e)}")
        
        await context.close()
        
        self.results['cross_role_protection'][authenticated_user] = blocked_count == len(other_dashboards)
        return blocked_count == len(other_dashboards)

    async def test_logout(self, page):
        """Test logout functionality"""
        print("\n🚪 Testing Logout...")
        
        try:
            # Look for logout elements
            logout_selectors = [
                'text="Cerrar Sesión"',
                'text="Logout"',
                '[wire\\:click*="logout"]',
                'a[href*="logout"]'
            ]
            
            logout_element = None
            for selector in logout_selectors:
                try:
                    logout_element = await page.query_selector(selector)
                    if logout_element:
                        print(f"   Found logout element with selector: {selector}")
                        break
                except:
                    continue
            
            if logout_element:
                await logout_element.click()
                await page.wait_for_load_state('networkidle')
                
                current_url = page.url
                if "login" in current_url:
                    print("   ✅ Logout successful - redirected to login")
                    return True
                else:
                    print(f"   ❌ Logout failed - current URL: {current_url}")
                    return False
            else:
                print("   ❌ Logout element not found")
                return False
                
        except Exception as e:
            print(f"   ❌ Error during logout: {str(e)}")
            return False

    async def run_comprehensive_test(self):
        """Run all tests"""
        print("🚀 COMPREHENSIVE LARAVEL RBAC SYSTEM TESTING")
        print("=" * 60)
        
        async with async_playwright() as p:
            browser = await p.chromium.launch(headless=True)
            
            try:
                # Test 1: Authentication for all users
                print("\n📋 PHASE 1: AUTHENTICATION TESTING")
                authenticated_sessions = {}
                
                for user_key in ['usuario', 'admin', 'superadmin']:
                    page, context = await self.test_user_login(browser, user_key)
                    if page and context:
                        authenticated_sessions[user_key] = (page, context)
                
                # Test 2: Dashboard functionality
                print("\n📋 PHASE 2: DASHBOARD FUNCTIONALITY TESTING")
                for user_key, (page, context) in authenticated_sessions.items():
                    await self.test_dashboard_functionality(page, user_key)
                
                # Test 3: Cross-role access protection
                print("\n📋 PHASE 3: CROSS-ROLE ACCESS PROTECTION")
                for user_key in authenticated_sessions.keys():
                    await self.test_cross_role_access(browser, user_key)
                
                # Test 4: Logout (test with one user)
                if 'superadmin' in authenticated_sessions:
                    page, context = authenticated_sessions['superadmin']
                    await self.test_logout(page)
                
                # Clean up
                for page, context in authenticated_sessions.values():
                    await context.close()
                
                # Print final results
                self.print_final_results()
                
            finally:
                await browser.close()

    def print_final_results(self):
        """Print comprehensive test results"""
        print("\n" + "=" * 60)
        print("📊 FINAL TEST RESULTS")
        print("=" * 60)
        
        # Authentication results
        print("\n🔐 AUTHENTICATION TESTS:")
        for user, result in self.results['login_tests'].items():
            status = "✅ PASS" if result else "❌ FAIL"
            print(f"   {user.title()}: {status}")
        
        # Dashboard access results
        print("\n🏠 DASHBOARD ACCESS TESTS:")
        for user, result in self.results['dashboard_access'].items():
            status = "✅ PASS" if result else "❌ FAIL"
            print(f"   {user.title()}: {status}")
        
        # Cross-role protection results
        print("\n🔒 CROSS-ROLE PROTECTION TESTS:")
        for user, result in self.results['cross_role_protection'].items():
            status = "✅ PASS" if result else "❌ FAIL"
            print(f"   {user.title()}: {status}")
        
        # UI Elements found
        print("\n🎨 UI ELEMENTS DETECTED:")
        for user, elements in self.results['ui_elements'].items():
            print(f"   {user.title()}: {elements}")
        
        # Overall summary
        total_tests = (len(self.results['login_tests']) + 
                      len(self.results['dashboard_access']) + 
                      len(self.results['cross_role_protection']))
        
        passed_tests = (sum(self.results['login_tests'].values()) + 
                       sum(self.results['dashboard_access'].values()) + 
                       sum(self.results['cross_role_protection'].values()))
        
        print(f"\n🎯 OVERALL SCORE: {passed_tests}/{total_tests} tests passed")
        
        if passed_tests == total_tests:
            print("🎉 ALL TESTS PASSED! RBAC system is working correctly.")
            return True
        else:
            print(f"⚠️  {total_tests - passed_tests} tests failed. Review needed.")
            return False

async def main():
    tester = ComprehensiveRBACTest()
    success = await tester.run_comprehensive_test()
    return 0 if success else 1

if __name__ == "__main__":
    sys.exit(asyncio.run(main()))