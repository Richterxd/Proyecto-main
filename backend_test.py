#!/usr/bin/env python3
"""
Laravel RBAC System Backend Test
Tests authentication, role-based access control, and API endpoints
"""

import requests
import sys
from datetime import datetime
import json

class LaravelRBACTester:
    def __init__(self, base_url="https://demobackend.emergentagent.com"):
        self.base_url = base_url
        self.session = requests.Session()
        self.tests_run = 0
        self.tests_passed = 0
        
        # Test users from UserSeeder
        self.test_users = {
            'superadmin': {
                'cedula': '12345678',
                'password': 'SuperAdmin123!',
                'role': 1,
                'expected_redirect': '/dashboard/superadmin'
            },
            'admin': {
                'cedula': '87654321', 
                'password': 'Admin123!',
                'role': 2,
                'expected_redirect': '/dashboard/administrador'
            },
            'usuario': {
                'cedula': '11223344',
                'password': 'Usuario123!',
                'role': 3,
                'expected_redirect': '/dashboard/usuario'
            }
        }

    def log_test(self, name, success, details=""):
        """Log test results"""
        self.tests_run += 1
        if success:
            self.tests_passed += 1
            print(f"✅ {name}")
        else:
            print(f"❌ {name} - {details}")
        
        if details and success:
            print(f"   ℹ️  {details}")

    def test_application_health(self):
        """Test if the Laravel application is running"""
        try:
            response = self.session.get(self.base_url, allow_redirects=True)
            # Laravel redirects to login, so check if we get login page
            success = (response.status_code == 200 and 
                      ('login' in response.url.lower() or 'login' in response.text.lower()))
            self.log_test("Application Health Check", success, 
                         f"Status: {response.status_code}, Final URL: {response.url}")
            return success
        except Exception as e:
            self.log_test("Application Health Check", False, str(e))
            return False

    def test_login_page_access(self):
        """Test login page accessibility"""
        try:
            response = self.session.get(f"{self.base_url}/login")
            success = response.status_code == 200 and 'login' in response.text.lower()
            self.log_test("Login Page Access", success, f"Status: {response.status_code}")
            return success
        except Exception as e:
            self.log_test("Login Page Access", False, str(e))
            return False

    def test_user_authentication(self, user_type):
        """Test user authentication with different roles"""
        user = self.test_users[user_type]
        
        try:
            # First get login page to get CSRF token
            login_response = self.session.get(f"{self.base_url}/login")
            
            # Extract CSRF token from the response
            csrf_token = None
            if 'csrf_token' in login_response.text or '_token' in login_response.text:
                # Try to extract token from meta tag or hidden input
                import re
                token_match = re.search(r'name=["\']_token["\'] content=["\']([^"\']+)["\']', login_response.text)
                if not token_match:
                    token_match = re.search(r'value=["\']([^"\']+)["\'][^>]*name=["\']_token["\']', login_response.text)
                if token_match:
                    csrf_token = token_match.group(1)

            # Prepare login data
            login_data = {
                'cedula': user['cedula'],
                'password': user['password']
            }
            
            if csrf_token:
                login_data['_token'] = csrf_token

            # Attempt login
            response = self.session.post(f"{self.base_url}/login", data=login_data, allow_redirects=True)
            
            # Check if login was successful (should redirect to dashboard)
            success = (response.status_code == 200 and 
                      ('dashboard' in response.url or 'Dashboard' in response.text))
            
            details = f"User: {user['cedula']}, Status: {response.status_code}, Final URL: {response.url}"
            self.log_test(f"Authentication - {user_type.title()}", success, details)
            
            return success, response
            
        except Exception as e:
            self.log_test(f"Authentication - {user_type.title()}", False, str(e))
            return False, None

    def test_dashboard_access(self, user_type, auth_response):
        """Test role-specific dashboard access"""
        user = self.test_users[user_type]
        
        try:
            # Test direct access to user's dashboard
            dashboard_url = f"{self.base_url}{user['expected_redirect']}"
            response = self.session.get(dashboard_url)
            
            success = response.status_code == 200
            details = f"Dashboard URL: {dashboard_url}, Status: {response.status_code}"
            self.log_test(f"Dashboard Access - {user_type.title()}", success, details)
            
            return success
            
        except Exception as e:
            self.log_test(f"Dashboard Access - {user_type.title()}", False, str(e))
            return False

    def test_cross_role_access_protection(self, current_user_type):
        """Test that users cannot access dashboards for other roles"""
        user = self.test_users[current_user_type]
        
        # Test access to other role dashboards
        other_dashboards = {
            'superadmin': '/dashboard/superadmin',
            'admin': '/dashboard/administrador', 
            'usuario': '/dashboard/usuario'
        }
        
        # Remove current user's dashboard from test
        del other_dashboards[current_user_type]
        
        blocked_count = 0
        total_tests = len(other_dashboards)
        
        for role, dashboard_path in other_dashboards.items():
            try:
                response = self.session.get(f"{self.base_url}{dashboard_path}", allow_redirects=True)
                
                # Should be redirected away from unauthorized dashboard
                is_blocked = (response.status_code in [302, 403] or 
                            dashboard_path not in response.url or
                            user['expected_redirect'] in response.url)
                
                if is_blocked:
                    blocked_count += 1
                    
                details = f"Accessing {role} dashboard: Status {response.status_code}, URL: {response.url}"
                self.log_test(f"Cross-Role Protection - {current_user_type} → {role}", is_blocked, details)
                
            except Exception as e:
                self.log_test(f"Cross-Role Protection - {current_user_type} → {role}", False, str(e))
        
        return blocked_count == total_tests

    def test_logout_functionality(self):
        """Test logout functionality"""
        try:
            # Get CSRF token for logout
            dashboard_response = self.session.get(f"{self.base_url}/dashboard")
            
            csrf_token = None
            if dashboard_response.status_code == 200:
                import re
                token_match = re.search(r'name=["\']_token["\'] content=["\']([^"\']+)["\']', dashboard_response.text)
                if token_match:
                    csrf_token = token_match.group(1)
            
            logout_data = {}
            if csrf_token:
                logout_data['_token'] = csrf_token
                
            # Attempt logout
            response = self.session.post(f"{self.base_url}/logout", data=logout_data, allow_redirects=True)
            
            # Should redirect to login or home page
            success = (response.status_code == 200 and 
                      ('login' in response.url.lower() or response.url == self.base_url + '/'))
            
            details = f"Status: {response.status_code}, Final URL: {response.url}"
            self.log_test("Logout Functionality", success, details)
            
            return success
            
        except Exception as e:
            self.log_test("Logout Functionality", False, str(e))
            return False

    def test_guest_route_protection(self):
        """Test that protected routes redirect unauthenticated users"""
        protected_routes = [
            '/dashboard',
            '/dashboard/usuario', 
            '/dashboard/administrador',
            '/dashboard/superadmin'
        ]
        
        # Create new session (unauthenticated)
        guest_session = requests.Session()
        
        protected_count = 0
        for route in protected_routes:
            try:
                response = guest_session.get(f"{self.base_url}{route}", allow_redirects=True)
                
                # Should redirect to login
                is_protected = ('login' in response.url.lower() or response.status_code == 401)
                
                if is_protected:
                    protected_count += 1
                    
                details = f"Route: {route}, Status: {response.status_code}, Final URL: {response.url}"
                self.log_test(f"Guest Protection - {route}", is_protected, details)
                
            except Exception as e:
                self.log_test(f"Guest Protection - {route}", False, str(e))
        
        return protected_count == len(protected_routes)

    def run_comprehensive_test(self):
        """Run all tests in sequence"""
        print("🚀 Starting Laravel RBAC System Tests")
        print("=" * 50)
        
        # Basic health checks
        if not self.test_application_health():
            print("❌ Application not accessible, stopping tests")
            return False
            
        if not self.test_login_page_access():
            print("❌ Login page not accessible, stopping tests")
            return False
        
        # Test guest route protection
        print("\n📋 Testing Guest Route Protection")
        self.test_guest_route_protection()
        
        # Test each user role
        for user_type in ['usuario', 'admin', 'superadmin']:
            print(f"\n👤 Testing {user_type.title()} Role")
            
            # Test authentication
            auth_success, auth_response = self.test_user_authentication(user_type)
            
            if auth_success:
                # Test dashboard access
                self.test_dashboard_access(user_type, auth_response)
                
                # Test cross-role access protection
                self.test_cross_role_access_protection(user_type)
                
                # Test logout (only once)
                if user_type == 'superadmin':
                    self.test_logout_functionality()
            else:
                print(f"   ⚠️  Skipping further tests for {user_type} due to auth failure")
        
        # Print final results
        print("\n" + "=" * 50)
        print(f"📊 Test Results: {self.tests_passed}/{self.tests_run} passed")
        
        if self.tests_passed == self.tests_run:
            print("🎉 All tests passed!")
            return True
        else:
            print(f"⚠️  {self.tests_run - self.tests_passed} tests failed")
            return False

def main():
    """Main test execution"""
    print("Laravel RBAC System Backend Tester")
    print("Testing authentication and role-based access control")
    print(f"Timestamp: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
    
    tester = LaravelRBACTester()
    success = tester.run_comprehensive_test()
    
    return 0 if success else 1

if __name__ == "__main__":
    sys.exit(main())