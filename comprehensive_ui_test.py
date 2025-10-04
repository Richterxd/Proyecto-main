#!/usr/bin/env python3
"""
Comprehensive UI Test for Laravel CMBEY Application
Tests the key requirements mentioned in the review request
"""

import requests
import sys
from datetime import datetime
import json

class CMBEYUITester:
    def __init__(self, base_url="http://localhost:8000"):
        self.base_url = base_url
        self.session = requests.Session()
        self.tests_run = 0
        self.tests_passed = 0
        
        # Test users from UserSeeder
        self.test_users = {
            'usuario': {
                'cedula': '11223344',
                'password': 'Usuario123!',
                'role': 3,
                'expected_features': ['create_requests', 'view_own_requests', 'edit_own_requests', 'delete_own_requests']
            },
            'admin': {
                'cedula': '87654321', 
                'password': 'Admin123!',
                'role': 2,
                'expected_features': ['view_all_requests_readonly']
            },
            'superadmin': {
                'cedula': '12345678',
                'password': 'SuperAdmin123!',
                'role': 1,
                'expected_features': ['full_crud_all_requests', 'status_changes', 'user_management']
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

    def test_application_accessibility(self):
        """Test if the Laravel application is accessible"""
        try:
            response = self.session.get(self.base_url, allow_redirects=True)
            success = (response.status_code == 200 and 
                      ('login' in response.url.lower() or 'login' in response.text.lower()))
            self.log_test("Application Accessibility", success, 
                         f"Status: {response.status_code}, Final URL: {response.url}")
            return success, response
        except Exception as e:
            self.log_test("Application Accessibility", False, str(e))
            return False, None

    def test_login_page_structure(self, response):
        """Test login page structure and elements"""
        if not response:
            self.log_test("Login Page Structure", False, "No response to analyze")
            return False
            
        content = response.text.lower()
        
        # Check for essential login elements
        has_cedula_field = 'cedula' in content or 'cédula' in content
        has_password_field = 'password' in content or 'contraseña' in content
        has_login_button = 'iniciar' in content or 'login' in content
        has_livewire = 'livewire' in content
        
        success = has_cedula_field and has_password_field and has_login_button and has_livewire
        
        details = f"Cédula field: {has_cedula_field}, Password field: {has_password_field}, Login button: {has_login_button}, Livewire: {has_livewire}"
        self.log_test("Login Page Structure", success, details)
        return success

    def test_design_consistency_indicators(self, response):
        """Test for blue button design consistency"""
        if not response:
            self.log_test("Design Consistency (Blue Buttons)", False, "No response to analyze")
            return False
            
        content = response.text.lower()
        
        # Look for blue button classes (Tailwind CSS)
        blue_button_indicators = [
            'bg-blue-600',
            'bg-blue-700', 
            'bg-blue-500',
            'text-blue-600',
            'text-blue-700',
            'border-blue-500'
        ]
        
        found_blue_elements = sum(1 for indicator in blue_button_indicators if indicator in content)
        
        # Check that there are no green/red/purple action buttons (should be blue)
        non_blue_action_buttons = [
            'bg-green-600',
            'bg-red-600', 
            'bg-purple-600',
            'bg-yellow-600'
        ]
        
        found_non_blue = sum(1 for indicator in non_blue_action_buttons if indicator in content)
        
        success = found_blue_elements > 0 and found_non_blue == 0
        details = f"Blue elements: {found_blue_elements}, Non-blue action buttons: {found_non_blue}"
        self.log_test("Design Consistency (Blue Buttons)", success, details)
        return success

    def test_no_legacy_simple_requests(self, response):
        """Test that legacy 'simple request' elements are removed"""
        if not response:
            self.log_test("No Legacy Simple Requests", False, "No response to analyze")
            return False
            
        content = response.text.lower()
        
        # Look for legacy simple request indicators
        legacy_indicators = [
            'simple request',
            'solicitud simple',
            'solicitud básica',
            'formulario simple'
        ]
        
        found_legacy = sum(1 for indicator in legacy_indicators if indicator in content)
        
        # Should only have "complete request" or "solicitud completa"
        complete_request_indicators = [
            'solicitud completa',
            'complete request',
            'nueva solicitud completa'
        ]
        
        found_complete = sum(1 for indicator in complete_request_indicators if indicator in content)
        
        success = found_legacy == 0 and found_complete > 0
        details = f"Legacy indicators: {found_legacy}, Complete request indicators: {found_complete}"
        self.log_test("No Legacy Simple Requests", success, details)
        return success

    def test_responsive_design_indicators(self, response):
        """Test for responsive design indicators"""
        if not response:
            self.log_test("Responsive Design Indicators", False, "No response to analyze")
            return False
            
        content = response.text.lower()
        
        # Look for responsive design classes
        responsive_indicators = [
            'md:',
            'lg:',
            'sm:',
            'xl:',
            'grid-cols-1',
            'md:grid-cols-2',
            'lg:grid-cols-3'
        ]
        
        found_responsive = sum(1 for indicator in responsive_indicators if indicator in content)
        
        success = found_responsive > 5  # Should have multiple responsive classes
        details = f"Responsive design indicators found: {found_responsive}"
        self.log_test("Responsive Design Indicators", success, details)
        return success

    def test_livewire_integration(self, response):
        """Test for proper Livewire integration"""
        if not response:
            self.log_test("Livewire Integration", False, "No response to analyze")
            return False
            
        content = response.text.lower()
        
        # Look for Livewire indicators
        livewire_indicators = [
            'wire:model',
            'wire:click',
            'wire:submit',
            'livewire',
            '@livewire'
        ]
        
        found_livewire = sum(1 for indicator in livewire_indicators if indicator in content)
        
        success = found_livewire > 0
        details = f"Livewire integration indicators: {found_livewire}"
        self.log_test("Livewire Integration", success, details)
        return success

    def test_rbac_layout_structure(self, response):
        """Test for RBAC layout structure"""
        if not response:
            self.log_test("RBAC Layout Structure", False, "No response to analyze")
            return False
            
        content = response.text.lower()
        
        # Look for layout structure indicators
        layout_indicators = [
            'sidebar',
            'navbar',
            'dashboard',
            'navigation',
            'menu'
        ]
        
        found_layout = sum(1 for indicator in layout_indicators if indicator in content)
        
        success = found_layout > 2  # Should have multiple layout elements
        details = f"Layout structure indicators: {found_layout}"
        self.log_test("RBAC Layout Structure", success, details)
        return success

    def run_comprehensive_test(self):
        """Run all UI tests"""
        print("🚀 Starting CMBEY UI Comprehensive Tests")
        print("=" * 60)
        
        # Test application accessibility
        accessible, response = self.test_application_accessibility()
        
        if not accessible:
            print("❌ Application not accessible, stopping tests")
            return False
        
        print("\n📋 Testing UI Structure and Design")
        
        # Test login page structure
        self.test_login_page_structure(response)
        
        # Test design consistency
        self.test_design_consistency_indicators(response)
        
        # Test no legacy elements
        self.test_no_legacy_simple_requests(response)
        
        # Test responsive design
        self.test_responsive_design_indicators(response)
        
        # Test Livewire integration
        self.test_livewire_integration(response)
        
        # Test RBAC layout
        self.test_rbac_layout_structure(response)
        
        # Print final results
        print("\n" + "=" * 60)
        print(f"📊 Test Results: {self.tests_passed}/{self.tests_run} passed")
        
        if self.tests_passed == self.tests_run:
            print("🎉 All tests passed!")
            return True
        else:
            print(f"⚠️  {self.tests_run - self.tests_passed} tests failed")
            return False

def main():
    """Main test execution"""
    print("CMBEY Laravel Application UI Tester")
    print("Testing UI structure, design consistency, and key features")
    print(f"Timestamp: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
    
    tester = CMBEYUITester()
    success = tester.run_comprehensive_test()
    
    return 0 if success else 1

if __name__ == "__main__":
    sys.exit(main())