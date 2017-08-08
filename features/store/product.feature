@store @product
Feature: Store product
  In order to see the product page properly
  As an anonymous user
  I need to be able to see some elements in the product page

  Scenario: View the product name
    Given I am on the product 6 page
    Then I should see product 6 name
    And the response should contain a "add-product-6-to-cart" test attribute