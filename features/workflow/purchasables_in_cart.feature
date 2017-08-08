@workflow @purchasable @cart
Feature: Purchasable in cart
  In order to be able to buy purchasabes
  As an admin user
  I need to be able to buy purchasables

  Scenario: Buy purchasables
    Given I am logged as "customer@customer.com" - "1234"
    And I go to "/cart/purchasable/1/add"
    And I follow "Checkout"
    And I press "Payment"
    When I go to "/payment/freepayment/execute"
    And I should see purchasable 1 name