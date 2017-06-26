@admin @product
Feature: Admin product
  In order to manage my products
  As an admin
  I need to be able to see all product views

  Scenario: See product list in admin with new product element
    Given In admin, I am logged as "admin@admin.com" - "1234"
    When I go to "/admin/products"
    Then the response should contain a "product-1" test attribute
    And the response should contain a "new-product" test attribute
